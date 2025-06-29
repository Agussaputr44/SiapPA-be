<?php

use App\Http\Controllers\ApiControllers\ArtikelsContoller;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\PengaduansController;
use App\Http\Controllers\ApiControllers\UploadsFilesController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // public routes
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Email verification: untuk user yang sudah login
    Route::middleware('auth:sanctum')->group(function () {
        // Kirim ulang email verifikasi
        Route::post('auth/email/verification-notification', function (Request $request) {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email already verified.'], 400);
            }

            $request->user()->sendEmailVerificationNotification();

            return response()->json(['message' => 'Verification link sent!']);
        });

        // Proses verifikasi email (link dari email)
        Route::get('auth/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email already verified.']);
            }

            if ($request->user()->markEmailAsVerified()) {
                // Bisa trigger event jika perlu
            }

            // Bisa pilih: JSON
            return response()->json(['message' => 'Email verified!']);
            // Atau redirect ke frontend:
            // return redirect('http://localhost:5173/email-verified');
        })->middleware(['signed'])->name('verification.verify');
        // Cek status verifikasi email
        Route::get('auth/email/check', function (Request $request) {
            return response()->json([
                'email_verified' => $request->user()->hasVerifiedEmail()
            ]);
        });

        // Route dengan middleware verified
        Route::middleware('verified')->group(function () {
            // users
            Route::post('auth/logout', [AuthController::class, 'logout']);
            Route::get('auth/users', [AuthController::class, 'getAllUser']);
            Route::get('auth/user', [AuthController::class, 'getUserProfile']);

            // upload files
            Route::post('uploads', [UploadsFilesController::class, 'uploadFiles']);

            // articles
            Route::post('artikels', [ArtikelsContoller::class, 'store']);
            Route::get('artikels', [ArtikelsContoller::class, 'index']);
            Route::get('artikels/{artikels_id}', [ArtikelsContoller::class, 'show']);
            Route::put('artikels/{artikels_id}', [ArtikelsContoller::class, 'update']);
            Route::delete('artikels/{artikels_id}', [ArtikelsContoller::class, 'destroy']);

            // pengaduans
            Route::get('pengaduans', [PengaduansController::class, 'index']);
            Route::post('pengaduans', [PengaduansController::class, 'store']);
            Route::get('pengaduans/{pengaduans_id}', [PengaduansController::class, 'show']);
            Route::delete('pengaduans/{pengaduans_id}', [PengaduansController::class, 'destroy']);
            Route::put('pengaduans/{pengaduans_id}', [PengaduansController::class, 'update']);
        });
    });
});
