<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryOfStackResource;
use App\Http\Resources\PlayerResource;
use App\Models\CategoryOfStack;
use App\Models\Player;
use App\Models\Stack;
use App\Telegram\Services\RequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stack $stack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stack $stack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stack $stack)
    {
        //
    }

    public function getStackCatergories(Request $request)
    {
        $catergory = CategoryOfStack::with('stacks')->get();

        return CategoryOfStackResource::collection($catergory);
    }

    public function addMainStackToPlayer(Request $request): PlayerResource|JsonResponse
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        $validator = Validator::make($request->route()->parameters(), [
            'stack_id' => ['required', 'integer', 'exists:stacks,id',],
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 404);
        }

        $stack_id = request('stack_id');
        $chatId  = RequestData::getChatId($initData);

        $player = Player::query()
            ->where('chat_id', $chatId)
            ->first();
        if (!$player) {
            return response()->json('Player not found', 419);
        }

        $player->setAttribute('main_stack_id', $stack_id)
            ->save();

        return (new PlayerResource($player->fresh()));
    }

    public function getMainStacks()
    {
        // is_main
    }
}
