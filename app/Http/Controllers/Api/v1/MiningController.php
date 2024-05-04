<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class MiningController extends Controller
{
    public function taps(): JsonResponse
    {
        $update = Telegram::commandsHandler(true);
        $update_array = json_decode($update, TRUE);
        Log::debug('[MiningController][taps]', [
            $update_array
        ]);

        return response()->json('ok');
    }

    public function incrementTaps(Request $request): JsonResponse
    {
        return response()->json('ok');
    }
}
