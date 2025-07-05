<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


/**
 * SocialiteController handles Google OAuth authentication.
 * It redirects users to Google for authentication and handles the token response.
 */
class ThirdPartyController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        // Log session status
        if (session()->isStarted()) {
            Log::info('Session started');
        } else {
            Log::info('Session not started');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback and retrieve the user information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleToken(Request $request)
    {
        try {
            $request->validate([
                'id_token' => 'required|string'
            ]);

            $client = new \Google_Client(['client_id' => config('services.google.client_id')]);
            $payload = $client->verifyIdToken($request->id_token);

            if (!$payload) {
                return response()->json(['error' => 'Invalid token'], 401);
            }

            // Cek user, jika belum ada, create dan set email_verified_at
            $user = User::where('email', $payload['email'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'password' => bcrypt(Str::random(16)), 
                    'foto_profile' => $payload['picture'] ?? null,
                    'email_verified_at' => now(), 
                ]);
            } elseif (!$user->hasVerifiedEmail()) {
                $user->email_verified_at = now();
                $user->save();
            }

            $token = $user->createToken('FlutterApp')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            return response()->json(['error' => 'Authentication failed'], 500);
        }
    }
}
