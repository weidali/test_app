<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Laravel\Facades\Telegram;

class MiningController extends Controller
{
    public function getTapsCounts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->route()->parameters(), [
            'chatId' => ['required', 'integer',],
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 404);
        }
        $chatId = request('chatId');

        $player = Player::where('chat_id', $chatId)->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        Log::debug('[MiningController][taps]', [
            $player
        ]);

        return response()->json([
            'balance' => $player->balance,
            'score' => $player->score,
            'multiplier' => $player->multiplier,
            'created_at' => $player->created_at,
        ]);
    }

    public function incrementTaps(Request $request): JsonResponse
    {
        return response()->json('ok');
    }
}
