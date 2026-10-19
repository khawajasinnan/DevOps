@extends('layouts.app')

@section('title', 'New Task')

@section('content')
<a href="{{ route('todos.index') }}" class="back-link">
    ← Back to Tasks
</a>

<div class="form-card">
    <div class="form-header">
        <h1 class="page-title">Create New Task</h1>
        <p class="page-subtitle">Add a new task to your to-do list</p>
    </div>

    <form action="{{ route('todos.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">
                Task Title <span class="required">*</span>
            </label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-input @error('title') is-invalid @enderror"
                value="{{ old('title') }}"
                placeholder="What needs to be done?"
                required
                autofocus
            >
            @error('title')
                <span class="error-message">⚠️ {{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">
                Description <span class="optional">(optional)</span>
            </label>
            <textarea
                name="description"
                id="description"
                rows="5"
                class="form-textarea @error('description') is-invalid @enderror"
                placeholder="Add more details, links, or notes..."
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="error-message">⚠️ {{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Task</button>
        </div>
    </form>
</div>
@endsection
