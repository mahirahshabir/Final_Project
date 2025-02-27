<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(){
        Task::create([
            'name' => 'Setup Authentication',
            'description' => 'Implement login and register using Laravel Breeze.',
            'project_id' => 1, // Ensure project exists in DB
            'deadline' => '2025-03-05',
        ]);

        Task::create([
            'name' => 'Database Migrations',
            'description' => 'Create migrations for users, projects, and tasks.',
            'project_id' => 1,
            'deadline' => '2025-03-07',
        ]);
}
}
