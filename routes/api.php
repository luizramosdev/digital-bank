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
        Route::get('/user/auth', [UserController::class, 'userAuth']);
        Route::get('/user/{user_id}', [UserController::class, 'show']);
        Route::get('/account/auth', [AccountController::class, 'accountAuth']);
        Route::get('/account/{account_id}', [AccountController::class, 'show']);
        Route::post('/transfer/ted', [TransferController::class, 'transferTed']);
        Route::post('/pix', [PixController::class, 'store']);
        Route::get('/pix/{key}', [PixController::class, 'show']);
        Route::post('/transfer/pix', [TransferController::class, 'transferPix']);
    });
});
