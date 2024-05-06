<?php

use App\Http\Controllers\TelegramBotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/<token>/webhook', [TelegramBotController::class, 'handleWebhook']);

Route::get('/show', [TelegramBotController::class, 'show']);
Route::get('admin/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/test', function () {

    $chatId = '1830325083';

    $url = 'https://t.me/dev_kombat_bot?start=' . $chatId;
    $text = 'Share *DevKombat* with your firends and earn bonuses for each friend you invite and for their activity.' . PHP_EOL . PHP_EOL;
    $text .= 'Copy and share it' . PHP_EOL;
    $text .= '👉 `' . $url . '`';

    // +++
    $telegram = new \Telegram\Bot\Api();
    $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'MarkDown',
    ]);

    // +++
    return null;
});
