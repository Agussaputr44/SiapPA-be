<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/auth/users",
     *     operationId="getAllUsers",
     *     tags={"Users"},
     *     summary="Get all users",
     *     description="Returns a list of all users",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function getAllUser()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     operationId="register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Creates a new user and returns an authentication token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe", description="Nama pengguna"),
     *             @OA\Property(property="email", type="string", example="john@example.com", description="Email pengguna"),
     *             @OA\Property(property="password", type="string", example="password123", description="Kata sandi pengguna")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        // Tidak perlu generate token di sini, karena user belum bisa akses API sebelum verified
        return response()->json([
            'message' => 'Registration successful. Please check your email for verification link before logging in.',
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     operationId="login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     description="Authenticates a user and returns an authentication token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="john@example.com", description="Email pengguna"),
     *             @OA\Property(property="password", type="string", example="password123", description="Kata sandi pengguna")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login failed, please check your credentials.',
            ], 401);
        }

        // Tambahkan cek verifikasi email
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Please verify your email address before logging in. We have sent you a verification email.',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'user_data' => $user,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     description="Logs out the authenticated user and revokes the token",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully", description="Pesan sukses")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/user",
     *     operationId="getUserProfile",
     *     tags={"Users"},
     *     summary="Get authenticated user profile",
     *     description="Returns the profile of the authenticated user",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true, description="Status keberhasilan"),
     *             @OA\Property(property="user", ref="#/components/schemas/User", description="Data pengguna"),
     *             @OA\Property(property="message", type="string", example="User profile retrieved successfully", description="Pesan sukses")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function getUserProfile(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'User profile retrieved successfully',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    private function sanitizeUrl($url)
    {
        $baseUrl = config('app.url') . '/storage/';
        if (str_starts_with($url, $baseUrl . $baseUrl)) {
            return str_replace($baseUrl . $baseUrl, $baseUrl, $url);
        }
        return $url;
    }

    /**
     * @OA\Put(
     *     path="/api/v1/auth/user",
     *     operationId="updateProfile",
     *     tags={"Users"},
     *     summary="Update authenticated user profile",
     *     description="Updates the profile of the authenticated user",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe Updated", description="Nama pengguna", nullable=true),
     *             @OA\Property(property="foto_profil", type="string", example="path/to/newfoto.jpg", description="Path atau URL foto profil", nullable=true),
     *             @OA\Property(property="password", type="string", example="newpassword123", description="Kata sandi baru", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true, description="Status keberhasilan"),
     *             @OA\Property(property="message", type="string", example="Profile updated successfully", description="Pesan sukses"),
     *             @OA\Property(property="user", ref="#/components/schemas/User", description="Data pengguna")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function updateProfile(Request $request)
    {
        Log::info('Incoming request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'foto_profil' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            Log::error('Validation errors:', $validator->errors()->toArray());
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();
        $updateData = [];

        Log::info('User before update:', $user->toArray());

        if ($request->has('name') && !empty($request->input('name'))) {
            $updateData['name'] = $request->input('name');
        }

        if ($request->has('password') && strlen($request->password) >= 8) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($request->has('foto_profil') && !empty($request->input('foto_profil'))) {
            $updateData['foto_profil'] = $this->sanitizeUrl($request->input('foto_profil'));
        }

        if (isset($updateData['foto_profil'])) {
            Log::info('Profile picture URL updated:', ['foto_profil' => $updateData['foto_profil']]);
        }

        Log::info('Profile update data:', $updateData);

        $user->fill($updateData);
        $user->save();

        Log::info('User after update:', $user->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/auth/user/password",
     *     operationId="updatePassword",
     *     tags={"Users"},
     *     summary="Update authenticated user password",
     *     description="Updates the password of the authenticated user",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="current_password", type="string", example="password123", description="Kata sandi saat ini"),
     *             @OA\Property(property="new_password", type="string", example="newpassword123", description="Kata sandi baru")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true, description="Status keberhasilan"),
     *             @OA\Property(property="message", type="string", example="Password updated successfully.", description="Pesan sukses")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized or incorrect current password",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ], 200);
    }
}
