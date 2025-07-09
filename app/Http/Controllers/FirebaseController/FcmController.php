<?php

namespace App\Http\Controllers\FirebaseController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Google\Auth\OAuth2;



class FcmController extends Controller
{
    public function send()
    {
        // Lokasi file JSON credentials
        $credentialsPath = storage_path('app/firebase/firebase_credentials.json');

        // Baca isi JSON
        $jsonKey = json_decode(file_get_contents($credentialsPath), true);

        // Buat OAuth token
        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $jsonKey['client_email'],
            'signingAlgorithm' => 'RS256',
            'signingKey' => $jsonKey['private_key'],
            'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        ]);

        $accessToken = $oauth->fetchAuthToken()['access_token'];

        // Data FCM
        $projectId = 'siappa-464615';
        $deviceToken = 'FCM_DEVICE_TOKEN';

        $payload = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => 'Judul Notifikasi',
                    'body' => 'Isi notifikasi di sini'
                ],
                'data' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                ],
            ],
        ];

        // Kirim request ke FCM
        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

        return response()->json($response->json());
    }
}
