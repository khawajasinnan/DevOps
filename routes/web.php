<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Tier 2 (Application Layer) — Route definitions mapping URLs to controller
| actions. This is the entry point for all HTTP requests.
|
*/

// Redirect root to todos list
Route::get('/', function () {
    return redirect()->route('todos.index');
});

// RESTful resource routes for todos (index, create, store, show, edit, update, destroy)
Route::resource('todos', TodoController::class);

// Custom route for toggling todo completion status
Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggleComplete'])
    ->name('todos.toggle');
