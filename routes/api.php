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
    'prefix' => 'mining'
], function ($router) {
    Route::group([
        'prefix' => 'taps'
    ], function ($router) {
        Route::get('/', [\App\Http\Controllers\Api\v1\MiningController::class, 'getTapsCounts']);
        Route::get('increment/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementTaps']);
    });
});
