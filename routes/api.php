<?php

use App\Http\Controllers\ApiControllers\ArtikelsContoller;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\PengaduansController;
use App\Http\Controllers\ApiControllers\ThirdPartyController;
use App\Http\Controllers\ApiControllers\UploadsFilesController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

Route::prefix('v1')->group(function () {

    // public routes
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/google', [ThirdPartyController::class, 'handleGoogleToken']);


    Route::get('auth/email/verify/{id}/{hash}', function (Request $request) {
        $user = User::findOrFail($request->route('id'));

        // Cek hash valid
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'Email berhasil diverifikasi. Silakan login.']);
    })->middleware(['signed'])->name('verification.verify');


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
            Route::put('auth/user', [AuthController::class, 'updateProfile']);
            Route::put('auth/update-password', [AuthController::class, 'updatePassword']);

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
