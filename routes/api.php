<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('news', [NewsController::class, 'index']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user', [AuthController::class, 'getUserInfo']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
