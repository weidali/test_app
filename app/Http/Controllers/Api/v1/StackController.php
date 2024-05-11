<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryOfStackResource;
use App\Models\CategoryOfStack;
use App\Models\Stack;
use Illuminate\Http\Request;

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
}
