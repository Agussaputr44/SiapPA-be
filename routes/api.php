<?php

use App\Http\Controllers\ApiControllers\ArtikelsContoller;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\ArtikelsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {


    // public routes
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // auth routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/users', [AuthController::class, 'getAllUser']);
        Route::get('auth/artikels', [ArtikelsContoller::class, 'index']);
        Route::get('auth/artikels/{artikels_id}', [ArtikelsContoller::class, 'show']);
        Route::get('auth/user', [AuthController::class, 'getUserProfile']);
    });
});
