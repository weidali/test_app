<?php

namespace App\Http\Controllers;

use App\Models\Player;
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
        // $update = Telegram::commandsHandler(true);
        $update = $this->telegram->getWebhookUpdate();
        $update_array = json_decode($update, TRUE);
        // Log::info('update', [$update_array]);

        $chatId = $update_array["message"]["chat"]["id"];
        $text = $update_array["message"]["text"];
        $username = $update_array["message"]["from"]['username'];

        $player = Player::firstOrCreate(['chat_id' => $chatId], [
            'username' => $username,
        ]);

        switch ($text) {
            case '/help':
                $this->telegram->triggerCommand('help', $update);

            case '/start':
                $this->telegram->triggerCommand('start', $update);
            case "/me":
                $this->sendProfileInfo($chatId, $player);

            case "/admin":
                if (Player::isAdmin($chatId)) {
                    // $this->sendAdminMenu($chatId);
                    $this->sendAdminInfo($chatId, $username);
                } else {
                    $message = "403 Not supported";
                    $this->sendMessage($chatId, $message);
                }
        }

        return response()->json([
            'status' => 'ok',
        ]);
    }

    private function sendProfileInfo(string $chat_id, Player $player)
    {
        $score = $player->score;
        $balance = $player->balance;
        $username = $player->username;
        $league = 'Diamond League';

        $text = "@$username *profile* " . PHP_EOL . PHP_EOL . "🏆 " . $league . PHP_EOL . "🪙 Total score: " . $score . PHP_EOL . "🪙 Balance: " . $balance . PHP_EOL . PHP_EOL . "/profile for personal stats";
        $response = $this->telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'MarkDown',
        ]);
    }

    private function sendAdminInfo(string $chat_id, string $username)
    {
        $total_players = Player::count();
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL . "🪙 Total players: " . $total_players . PHP_EOL . PHP_EOL . "/admin for admin info";
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
        // Log::info('response', [$response]);

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

    private function sendAdminMenu(string $chatId)
    {
        $keyboard = [
            ['Список игроков'],
            ['Статистика']
        ];

        $replyMarkup = [
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];

        $response = $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Выберите действие:',
            // 'reply_markup' => json_encode($replyMarkup),
        ]);
    }
}
