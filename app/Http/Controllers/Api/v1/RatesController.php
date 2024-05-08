<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\PlayerBalanceRating;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    function getUsers(Request $request): JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::query()
            ->with(['referrer', 'referrals'])
            ->where('chat_id', $chatId)->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }

        $users_count = Player::count();
        $rates = PlayerBalanceRating::query()
            ->orderBy('avg_rating', 'asc')
            ->limit(PlayerBalanceRating::SHOW_LIMIT)
            ->get();

        $players = [];
        foreach ($rates as $rating) {
            $players[] = [
                'username' => $rating->player->username,
                'balance' => $rating->player->balance,
                'rating' => $rating->avg_rating,
            ];
        }

        return response()->json([
            'total' => $users_count,
            'players' => $players ?? null,
            'own_rating' => $player->position,
        ]);
    }
}
