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
    public function getAllUser(){
        $users = User::all();
        return response()->json($users, 200);
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Kirim error jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Response
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }


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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'user_data' => $user,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


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
