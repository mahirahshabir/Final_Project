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
     $tasks = [
            ['name' => 'Database Setup', 'description' => 'Set up the database schema and migrations.'],
            ['name' => 'API Development', 'description' => 'Create RESTful APIs for project management.'],
            ['name' => 'Frontend Integration', 'description' => 'Integrate the frontend with the backend.'],
            ['name' => 'Testing & Debugging', 'description' => 'Perform unit and integration testing.'],
            ['name' => 'User Authentication', 'description' => 'Implement login and registration features.'],
            ['name' => 'Deployment Setup', 'description' => 'Prepare the application for deployment']
     ];
     foreach ($tasks as $task) {
            Task::create($task);

}
}
}