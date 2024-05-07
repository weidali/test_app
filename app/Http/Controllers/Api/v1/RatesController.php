<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
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
        $rates = Player::query()
            ->select(['username', 'balance'])
            ->orderBy('balance', 'asc')
            ->limit(3)
            ->get()
            ->each
            ->setAppends(['position']);

        for ($i = 0; $i < count($rates); $i++) {
            // dump($i + 1);
            // $rates[$i]->position = $i;
            // if ($student_subject_marks_for_position == $class_subject_marks_for_position[$i]) {
            //     $position = $i;
            //     break;
            // }
        }

        return response()->json([
            'total' => $users_count,
            'rates' => $rates,
        ]);
    }
}
