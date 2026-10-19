@extends('layouts.app')

@section('title', $todo->title)

@section('content')
<a href="{{ route('todos.index') }}" class="back-link">
    ← Back to Tasks
</a>

<div class="detail-card">
    <div class="detail-header">
        <h1 class="detail-title">{{ $todo->title }}</h1>
        <span class="status-badge {{ $todo->is_completed ? 'completed' : 'pending' }}">
            <span class="status-dot"></span>
            {{ $todo->is_completed ? 'Completed' : 'Pending' }}
        </span>
    </div>

    <div class="detail-section-label">Description</div>
    @if($todo->description)
        <div class="detail-description">{{ $todo->description }}</div>
    @else
        <div class="detail-description empty">No description provided.</div>
    @endif

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-label">Created</span>
            <span class="meta-value">{{ $todo->created_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Last Updated</span>
            <span class="meta-value">{{ $todo->updated_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
    </div>

    <div class="detail-actions">
        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $todo->is_completed ? 'btn-secondary' : 'btn-success' }}">
                <span class="toggle-btn {{ $todo->is_completed ? 'completed' : '' }}">{{ $todo->is_completed ? '✓' : '' }}</span>
                {{ $todo->is_completed ? 'Mark as Pending' : 'Mark as Completed' }}
            </button>
        </form>

        <div class="detail-actions-right">
            <a href="{{ route('todos.edit', $todo) }}" class="btn btn-secondary">
                Edit Task
            </a>
            <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    Delete Task
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
