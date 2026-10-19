@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<a href="{{ route('todos.index') }}" class="back-link">
    ← Back to Tasks
</a>

<div class="form-card">
    <div class="form-header">
        <h1 class="page-title">Edit Task</h1>
        <p class="page-subtitle">Update your task details and information</p>
    </div>

    <form action="{{ route('todos.update', $todo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">
                Task Title <span class="required">*</span>
            </label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-input @error('title') is-invalid @enderror"
                value="{{ old('title', $todo->title) }}"
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
            >{{ old('description', $todo->description) }}</textarea>
            @error('description')
                <span class="error-message">⚠️ {{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>
</div>
@endsection
