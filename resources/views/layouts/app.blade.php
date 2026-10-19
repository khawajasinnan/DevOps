<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A beautiful 3-tier Laravel To-Do List Application">
    <title>@yield('title', 'Todo App') — Laravel To-Do</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('todos.index') }}" class="navbar-brand">
                <span class="logo-icon">✓</span> TaskFlow
            </a>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>TaskFlow — Built with Laravel | 3-Tier Architecture</p>
        </div>
    </footer>
</body>
</html>
