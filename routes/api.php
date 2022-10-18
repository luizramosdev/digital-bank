<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PixController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\BilletController;
use App\Http\Controllers\v1\AccountController;
use App\Http\Controllers\v1\TransferController;

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
    });

    Route::middleware('auth:api')->group(function() {

        Route::group(['prefix' => 'user'], function () {
            Route::get('/auth', [UserController::class, 'userAuth']);
            Route::get('/{user_id}', [UserController::class, 'show']);
        });

        Route::group(['prefix' => 'account'], function () {
            Route::get('/auth', [AccountController::class, 'accountAuth']);
            Route::get('/{account_id}', [AccountController::class, 'show']);
        });

        Route::group(['prefix' => 'transfer'], function () {
            Route::post('/ted', [TransferController::class, 'transferTed']);
            Route::post('/pix', [TransferController::class, 'transferPix']);
        });

        Route::group(['prefix' => 'pix'], function () {
            Route::post('/', [PixController::class, 'store']);
            Route::get('/{key}', [PixController::class, 'show']);
        });

        Route::group(['prefix' => 'billet'], function () {
            Route::post('/', [BilletController::class, 'store']);
        });
    });
});
