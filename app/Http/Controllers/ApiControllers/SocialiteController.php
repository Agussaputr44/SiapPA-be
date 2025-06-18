<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
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
    
    public function handleGoogleToken(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'id_token' => 'required|string'
            ]);

            // Verify token with Google
            $client = new \Google_Client(['client_id' => config('services.google.client_id')]);
            $payload = $client->verifyIdToken($request->id_token);

            if (!$payload) {
                return response()->json(['error' => 'Invalid token'], 401);
            }

            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $payload['email']],
                [
                    'name' => $payload['name'],
                    'password' => bcrypt(Str::random(16)),
                    'foto_profile' => $payload['picture'] ?? null,
                ]
            );

            // Generate token
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
