<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Http\Resources\PlayerResource;
use App\Models\Level;
use App\Models\Player;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MiningController extends Controller
{
    public function start(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        // TODO
        $secret_token = $request->header('X-Telegram-Bot-Api-Secret-Token');

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
        Log::debug('[MiningController][getUser]', [
            $player
        ]);

        return new PlayerResource($player);
    }

    public function incrementTaps(Request $request): PlayerResource
    {
        $count = request('count');
        $validator = Validator::make($request->route()->parameters(), [
            'count' => ['required', 'integer',],
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 404);
        }

        $player = $this->getPlayerFromRequest($request);
        if (!$player)
            return response()->json('Player not found', 419);
        Log::debug('[MiningController][incrementTaps]', [
            $player
        ]);

        $player->setAttribute('taps', $count + $player->taps);
        $player->setAttribute('checkin', now());
        $player->save();
        $player = $player->fresh();

        return new PlayerResource($player);
    }

    function checkin(Request $request): PlayerResource|JsonResponse
    {
        $player = $this->getPlayerFromRequest($request);
        if (!$player)
            return response()->json('Player not found', 419);

        $player->setAttribute('checkin', now())->save();

        return (new PlayerResource($player->fresh()));
    }

    public function getLevels(Request $request): AnonymousResourceCollection
    {
        $levels = Level::orderBy('position')->get();
        // dd(LevelResource::collection($levels));
        return LevelResource::collection($levels);
    }

    public function checkLevel(Request $request): PlayerResource|JsonResponse
    {
        $player = $this->getPlayerFromRequest($request);
        if (!$player)
            return response()->json('Player not found', 419);

        $position = Player::checkPosition();
        $player->setLevelAttribute($position);
        $player->save;

        return (new PlayerResource($player->fresh()));
    }

    public function getPlayerFromRequest(Request $request): Player|null
    {
        // TODO
        $initData = $request->header('X-Telegram-WebApp-initData');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::where('chat_id', $chatId)->first();
        if (!$player)
            return null;

        return $player;
    }
}
