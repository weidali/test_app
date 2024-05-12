<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
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
