<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryOfStack;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $categories = CategoryOfStack::all();

        return view('pages.stack.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'string|max:255',
            'category_id' => 'numeric|exists:category_of_stacks,id',
        ]);

        $stack = DB::table('stacks')
            ->select('title')
            ->where(DB::raw('lower(title)'), 'like', '%' . strtolower($request['title']) . '%')
            ->first();
        if ($stack) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['errors' => 'Stack already exist.']);
        }
        $stack = Stack::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'category_id' => (int)$request['category_id'],
        ]);

        CategoryOfStack::find($request['category_id'])->stacks()->save($stack);

        return redirect()->route('stacks.index')
            ->with('success', 'Stack created successfully.');
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
        $categories = CategoryOfStack::orderBy('title')->get();
        // $post = Stack::find($id);
        return view('pages.stack.edit', compact('stack', 'categories'));
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
    public function destroy($id)
    {
        $stack = Stack::find($id);
        $stack->delete();

        return redirect()->route('stacks.index')
            ->with('success', 'Stack deleted successfully');
    }
}
