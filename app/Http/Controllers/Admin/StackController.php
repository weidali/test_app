<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stack;
use Illuminate\Http\Request;

class StackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stacks = Stack::with('category')->get();

        return view('pages.stack.index', compact('stacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
     * Show the form for editing the specified resource.
     */
    public function edit(Stack $stack)
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
}
