<?php

use App\Http\Controllers\ApiControllers\ArtikelsContoller;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\PengaduansController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {


    // public routes
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // auth routes
    Route::middleware('auth:sanctum')->group(function () {

        // users
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/users', [AuthController::class, 'getAllUser']);
        Route::get('auth/user', [AuthController::class, 'getUserProfile']);


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
