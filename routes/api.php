<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\AccountController;
use App\Http\Controllers\v1\PixController;
use App\Http\Controllers\v1\TransferController;

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
    });

    Route::middleware('auth:api')->group(function() {
        Route::get('/user', [UserController::class, 'show']);
        Route::get('/account', [AccountController::class, 'show']);
        Route::post('/transfer', [TransferController::class, 'transfer']);
        Route::post('/pix', [PixController::class, 'store']);
    });
});
