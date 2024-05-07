<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    // TODO
    // 'middleware' => 'auth',
    'middleware' => 'telegram.hash',
], function ($router) {
    Route::group([
        'prefix' => 'mining'
    ], function ($router) {
        Route::get('start', [\App\Http\Controllers\Api\v1\MiningController::class, 'start']);
        Route::get('user', [\App\Http\Controllers\Api\v1\MiningController::class, 'getUser']);
        Route::group([
            'prefix' => 'taps'
        ], function ($router) {
            Route::get('increment/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementTaps']);
        });
    });
    Route::group([
        'prefix' => 'referrer'
    ], function ($router) {
        Route::get('link', [\App\Http\Controllers\Api\v1\ReferrerController::class, 'getLink']);
    });
});
