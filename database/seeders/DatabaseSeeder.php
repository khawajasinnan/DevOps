<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed sample to-do items for demonstration
        $todos = [
            [
                'title' => 'Set up Laravel project',
                'description' => 'Initialize a fresh Laravel application with proper configuration and environment setup.',
                'is_completed' => true,
            ],
            [
                'title' => 'Design database schema',
                'description' => 'Create the todos table migration with title, description, and completion status fields.',
                'is_completed' => true,
            ],
            [
                'title' => 'Build REST API controllers',
                'description' => 'Implement TodoController with full CRUD operations and form request validation.',
                'is_completed' => true,
            ],
            [
                'title' => 'Create Blade templates',
                'description' => 'Design and implement the frontend views using Blade templating engine with a modern CSS design.',
                'is_completed' => false,
            ],
            [
                'title' => 'Configure Docker environment',
                'description' => 'Set up Dockerfile and docker-compose.yaml for 3-tier deployment with separate app and database containers.',
                'is_completed' => false,
            ],
            [
                'title' => 'Write unit tests',
                'description' => 'Add PHPUnit tests for the Todo model, controller actions, and form validation rules.',
                'is_completed' => false,
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Push the final application to a cloud hosting provider with proper SSL and domain configuration.',
                'is_completed' => false,
            ],
        ];

        foreach ($todos as $todo) {
            Todo::create($todo);
        }
    }
}
