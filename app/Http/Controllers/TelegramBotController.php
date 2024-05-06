<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

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
        $update = Telegram::commandsHandler(true);
        if (!$update instanceof Update) {
            Log::debug('[handleWebhook]instanceof', [
                'instanceof' => $update instanceof Update,
                $update
            ]);
            return;
        }
        $chatId = $update->getChat()->id;
        Log::debug('[handleWebhook]instanceof', [
            'instanceof' => $update instanceof Update,
            $update
        ]);
        return;

        if (isset($update->message->entities) && $update->message->entities[0]->type == "bot_command") {
            $username = $update->message->from->username;
            $text = $update->message->text;
            switch ($text) {
                case "/admin":
                    if (Player::isAdmin($chatId)) {
                        $this->sendAdminInfo($chatId, $username);
                    }
                    break;
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
