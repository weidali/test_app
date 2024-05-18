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
        Route::get('checkin', [\App\Http\Controllers\Api\v1\MiningController::class, 'checkin']);
        Route::group([
            'prefix' => 'taps'
        ], function ($router) {
            Route::get('increment/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementTaps']);
            Route::get('earn-per-tap/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementEarnPerTap']);
            Route::get('max-taps/{count}', [\App\Http\Controllers\Api\v1\MiningController::class, 'incrementMaxTaps']);
        });
    });
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
        Route::get('/', [\App\Http\Controllers\Api\v1\StackController::class, 'getStacks']);
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
