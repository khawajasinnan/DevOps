@use('Illuminate\Support\Str')

@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="hero-header">
    <div>
        <h1 class="page-title">My Tasks</h1>
        <p class="page-subtitle">Organize and track your daily productivity</p>
    </div>
    <a href="{{ route('todos.create') }}" class="btn btn-primary">+ New Task</a>
</div>

<div class="stats-bar">
    <div class="stat-card stat-total">
        <div class="stat-info">
            <span class="stat-label">Total Tasks</span>
            <span class="stat-value">{{ isset($totalCount) ? $totalCount : $todos->count() }}</span>
        </div>
        <div class="stat-icon">📋</div>
    </div>
    <div class="stat-card stat-completed">
        <div class="stat-info">
            <span class="stat-label">Completed</span>
            <span class="stat-value">{{ isset($completedCount) ? $completedCount : $todos->where('is_completed', true)->count() }}</span>
        </div>
        <div class="stat-icon">✓</div>
    </div>
    <div class="stat-card stat-pending">
        <div class="stat-info">
            <span class="stat-label">Pending</span>
            <span class="stat-value">{{ isset($pendingCount) ? $pendingCount : $todos->where('is_completed', false)->count() }}</span>
        </div>
        <div class="stat-icon">⏳</div>
    </div>
</div>

<div class="filters-nav">
    <a href="{{ route('todos.index') }}" class="filter-pill {{ !request('filter') ? 'active' : '' }}">
        All
    </a>
    <a href="{{ route('todos.index', ['filter' => 'pending']) }}" class="filter-pill {{ request('filter') === 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('todos.index', ['filter' => 'completed']) }}" class="filter-pill {{ request('filter') === 'completed' ? 'active' : '' }}">
        Completed
    </a>
</div>

@if($todos->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📝</div>
        <h2 class="empty-title">No tasks yet! Create your first task.</h2>
        <p class="empty-text">Stay organized and get things done by adding your first to-do item.</p>
        <a href="{{ route('todos.create') }}" class="btn btn-primary">+ Create First Task</a>
    </div>
@else
    <div class="todo-list">
        @foreach($todos as $todo)
            <div class="todo-card {{ $todo->is_completed ? 'completed' : '' }}">
                <div class="todo-main">
                    <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="todo-toggle-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="toggle-btn {{ $todo->is_completed ? 'completed' : '' }}" title="{{ $todo->is_completed ? 'Mark as pending' : 'Mark as completed' }}">
                            {{ $todo->is_completed ? '✓' : '' }}
                        </button>
                    </form>

                    <div class="todo-content">
                        <h3 class="todo-title {{ $todo->is_completed ? 'completed' : '' }}">
                            {{ $todo->title }}
                        </h3>

                        @if($todo->description)
                            <p class="todo-desc">
                                {{ Str::limit($todo->description, 80) }}
                            </p>
                        @endif

                        <div class="todo-meta">
                            <span class="status-badge {{ $todo->is_completed ? 'completed' : 'pending' }}">
                                <span class="status-dot"></span>
                                {{ $todo->is_completed ? 'Completed' : 'Pending' }}
                            </span>
                            <span class="todo-time">
                                🕒 {{ $todo->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="todo-actions">
                    <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-secondary">View</a>
                    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
