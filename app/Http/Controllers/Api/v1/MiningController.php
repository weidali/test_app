<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MiningController extends Controller
{
    public function taps(): JsonResponse
    {
        return response()->json('ok');
    }

    public function incrementTaps(Request $request): JsonResponse
    {
        return response()->json('ok');
    }
}
