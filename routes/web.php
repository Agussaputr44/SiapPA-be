<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/send-fcm', [\App\Http\Controllers\FirebaseController\FcmController::class, 'send']);
