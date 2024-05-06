<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MiningController extends Controller
{
    public function start(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        [$chatId, $username] = RequestData::getCredentials($initData);

        $player = Player::firstOrCreate(['chat_id' => $chatId], [
            'username' => $username,
        ]);
        if ($player->wasRecentlyCreated) {
            return (new PlayerResource($player))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);;
        }

        return (new PlayerResource($player));
    }

    public function getUser(Request $request): PlayerResource
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::where('chat_id', $chatId)->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        Log::debug('[MiningController][getUser]', [
            $player
        ]);

        return new PlayerResource($player);
    }

    public function incrementTaps(Request $request): PlayerResource
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $count = request('count');

        $chatId  = RequestData::getChatId($initData);

        $player = Player::where('chat_id', $chatId)->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        Log::debug('[MiningController][incrementTaps]', [
            $player
        ]);


        $validator = Validator::make($request->route()->parameters(), [
            'count' => ['required', 'integer',],
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 404);
        }

        $player->setAttribute('taps', $count + $player->taps);
        $player->save();
        $player = $player->fresh();

        return new PlayerResource($player);
    }
}
