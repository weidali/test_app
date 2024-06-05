<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    public function getUser(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::query()
            ->with(['referrer', 'referrals'])
            ->where('chat_id', $chatId)
            ->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        Log::debug('[PlayerController][getUser]', [
            $player
        ]);

        return new PlayerResource($player);
    }

    public function createUser(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        [$chatId, $username] = RequestData::getCredentials($initData);

        $player = Player::firstOrCreate(['chat_id' => $chatId], [
            'username' => $username,
        ]);

        Log::debug('[PlayerController][createUser]', [
            $player
        ]);

        $player->setAttribute('is_active', true);
        $player->save();
        $player = $player->fresh();

        if ($player->wasRecentlyCreated) {
            return (new PlayerResource($player))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        return new PlayerResource($player);
    }

    public function activateUser(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        // TODO
        $secret_token = $request->header('X-Telegram-Bot-Api-Secret-Token');

        [$chatId, $username] = RequestData::getCredentials($initData);

        $player = Player::query()
            ->where('chat_id', $chatId)
            ->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }
        $player->setAttribute('is_active', true);
        if ($player->username == $username) {
            $player->setAttribute('username', $username);
            Log::debug('[PlayerController][activateUser]', [
                $player, $username,
            ]);
        }
        $player->save();
        $player = $player->fresh();

        return (new PlayerResource($player));
    }

    public function setTheme(Request $request): PlayerResource|JsonResponse
    {
        $theme = request('theme');
        $validator = Validator::make($request->route()->parameters(), [
            'theme' => ['required', 'string',],
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 404);
        }

        $player = RequestData::getPlayerFromRequest($request);
        if (!$player)
            return response()->json('Player not found', 419);

        $player->setAttribute('theme', $theme);
        $player->save();

        return (new PlayerResource($player->fresh()));
    }
}
