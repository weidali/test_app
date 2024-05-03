<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{

    protected $telegram;

    /**
     * Create a new controller instance.
     *
     * @param  Api  $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }


    public function handleWebhook(Request $request)
    {
        // Обработка входящего запроса от Telegram API
        $update = Telegram::commandsHandler(true);
        $update = json_decode($update, TRUE);
        $chatId = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        $username = $update["message"]["from"]['username'];
        // {"update_id":836343906,"message":
        //  {"message_id":27,"from":{"id":1992446148,"is_bot":false,"first_name":"Виталий","last_name":"В","username":"GoPsyhology","language_code":"ru"},
        //  "chat":{"id":1992446148,"first_name":"Виталий","last_name":"В","username":"GoPsyhology","type":"private"},"date":1714741933,"text":"/start","entities":[{"offset":0,"length":6,"type":"bot_command"}]}}}] 

        $this->sendProfileInfo($chatId, $username);
        // $messageId = $this->sendMessage('', '');

        return response()->json([
            'status' => 'ok',
        ]);
    }

    private function sendProfileInfo(string $chat_id, string $username)
    {
        $score = 37931863;
        $balance = 37931863;
        $league = 'Diamond League';

        $text = "@$username *profile* " . PHP_EOL . PHP_EOL . "🏆 " . $league . PHP_EOL . "🪙 Total score: " . $score . PHP_EOL . "🪙 Balance: " . $balance . PHP_EOL . PHP_EOL . "/profile for personal stats";
        $response = $this->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'MarkDown',
        ]);
    }

    /**
     * Show the bot information.
     */
    public function show()
    {
        $response = $this->telegram->getMe();
        Log::info('sdf', [$response]);

        return $response;
    }

    private function sendMessage(string $chat_id, string $text)
    {
        $response = $this->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
        ]);

        $messageId = $response->getMessageId();
        return $messageId;
    }

    public function set()
    {
        $url = 'https://ce85-185-182-193-115.ngrok-free.app';

        $response = Telegram::setWebhook(['url' => $url . '/<token>/webhook']);

        dump($response);
        return;
    }
}
