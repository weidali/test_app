<?php

use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/<token>/webhook', [TelegramBotController::class, 'handleWebhook']);

Route::get('/show', [TelegramBotController::class, 'show']);
