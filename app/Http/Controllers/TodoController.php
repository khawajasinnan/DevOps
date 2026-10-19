<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * Display a listing of all todos.
     */
    public function index(Request $request): View
    {
        $query = Todo::query()->latest();

        // Apply filter if provided
        $filter = $request->query('filter');

        if ($filter === 'completed') {
            $query->where('is_completed', true);
        } elseif ($filter === 'pending') {
            $query->where('is_completed', false);
        }

        $todos = $query->get();

        // Get counts for stats bar (always from all todos, not filtered)
        $allTodos = Todo::all();
        $totalCount = $allTodos->count();
        $completedCount = $allTodos->where('is_completed', true)->count();
        $pendingCount = $allTodos->where('is_completed', false)->count();

        return view('todos.index', compact(
            'todos',
            'filter',
            'totalCount',
            'completedCount',
            'pendingCount'
        ));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create(): View
    {
        return view('todos.create');
    }

    /**
     * Store a newly created todo in the database.
     */
    public function store(TodoRequest $request): RedirectResponse
    {
        Todo::create($request->validated());

        return redirect()
            ->route('todos.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified todo.
     */
    public function show(Todo $todo): View
    {
        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified todo.
     */
    public function edit(Todo $todo): View
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified todo in the database.
     */
    public function update(TodoRequest $request, Todo $todo): RedirectResponse
    {
        $todo->update($request->validated());

        return redirect()
            ->route('todos.show', $todo)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified todo from the database.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()
            ->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }

    /**
     * Toggle the completion status of a todo.
     */
    public function toggleComplete(Todo $todo): RedirectResponse
    {
        $todo->update([
            'is_completed' => !$todo->is_completed,
        ]);

        $status = $todo->is_completed ? 'completed' : 'marked as pending';

        return redirect()
            ->back()
            ->with('success', "Task {$status}!");
    }
}
