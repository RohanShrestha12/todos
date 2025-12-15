<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller

{

    public function index(Request $request)
    {
        $query = Todo::query();

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $todos = $query->get();

        return view('todos.index', compact('todos'));
    }


    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,completed'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('todos', 'public');
        }

        Todo::create($validated);

        return redirect()->route('todos.index')->with('success', 'Todo created successfully!');
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,completed'
        ]);

        if ($request->hasFile('image')) {
            if ($todo->image) {
                Storage::disk('public')->delete($todo->image);
            }
            $validated['image'] = $request->file('image')->store('todos', 'public');
        }

        $todo->update($validated);

        return redirect()->route('todos.index')->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        if ($todo->image) {
            Storage::disk('public')->delete($todo->image);
        }

        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully!');
    }
}
