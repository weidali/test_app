<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    // TODO
    // 'middleware' => 'auth',
    'prefix' => 'mining'
], function ($router) {
    Route::get('taps', [\App\Http\Controllers\Api\v1\MiningController::class, 'taps']);
    Route::post('increment-taps', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementTaps']);
});
