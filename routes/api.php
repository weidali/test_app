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
        'prefix' => 'user'
    ], function ($router) {
        Route::get('/', [\App\Http\Controllers\Api\v1\PlayerController::class, 'getUser']);
        Route::get('create', [\App\Http\Controllers\Api\v1\PlayerController::class, 'createUser']);
        Route::get('activate', [\App\Http\Controllers\Api\v1\PlayerController::class, 'activateUser']);
    });

    Route::group([
        'prefix' => 'mining'
    ], function ($router) {
        Route::get('start', [\App\Http\Controllers\Api\v1\MiningController::class, 'start']);
        Route::get('passive-earn', [\App\Http\Controllers\Api\v1\MiningController::class, 'makePassiveEarn']);
        Route::group([
            'prefix' => 'taps'
        ], function ($router) {
            Route::get('increment/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementTaps']);
            Route::get('earn-per-tap/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementEarnPerTap']);
            Route::get('max-taps/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementMaxTaps']);
        });
    });
    Route::get('sync', [\App\Http\Controllers\Api\v1\MiningController::class, 'syncApp']);
    Route::group([
        'prefix' => 'referral'
    ], function ($router) {
        Route::get('link', [\App\Http\Controllers\Api\v1\ReferrerController::class, 'getLink']);
    });
    Route::group([
        'prefix' => 'player'
    ], function ($router) {
        Route::get('theme/{theme}', [\App\Http\Controllers\Api\v1\PlayerController::class, 'setTheme']);
    });
    Route::group([
        'prefix' => 'users'
    ], function ($router) {
        Route::get('/', [\App\Http\Controllers\Api\v1\RatesController::class, 'getUsers']);
    });
    Route::group([
        'prefix' => 'stacks'
    ], function ($router) {
        Route::get('main', [\App\Http\Controllers\Api\v1\StackController::class, 'getMainStacks']);
        Route::get('categories', [\App\Http\Controllers\Api\v1\StackController::class, 'getStackCatergories']);
        Route::get('add-main/{stack_id}', [\App\Http\Controllers\Api\v1\StackController::class, 'addMainStackToPlayer']);
    });
    Route::group([
        'prefix' => 'levels'
    ], function ($router) {
        Route::get('', [\App\Http\Controllers\Api\v1\MiningController::class, 'getLevels']);
        Route::get('check', [\App\Http\Controllers\Api\v1\MiningController::class, 'checkLevel']);
    });
});
