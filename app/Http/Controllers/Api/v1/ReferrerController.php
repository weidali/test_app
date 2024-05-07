<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class ReferrerController extends Controller
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

    function getLink(Request $request): JsonResponse
    {
        $link = '';
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::where('chat_id', $chatId)->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        Log::debug('[ReferrerController][getLink]', [
            $player
        ]);

        $url = Player::TELEGRAM_BOT_BASE_URL . '?start=' . $chatId;

        $text = 'Share *DevKombat* with your firends and earn bonuses for each friend you invite and for their activity.' . PHP_EOL . PHP_EOL;
        $text .= 'Copy and share it' . PHP_EOL;
        $text .= '👉 `' . $url . '`';

        $response = $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'MarkDown',
        ]);

        if (!$response->getChat()->id) {
            Log::debug('[ReferrerController][wrong]', [
                'response' => $response,
            ]);
            return response()->json([
                'status' => 'Somthing wrong',
                'status' => 'Message not send',
            ], 400);
        }

        return response()->json([
            'link' => $link,
        ]);
    }
}
