<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     *    
          $tasks = [
            ['name' => 'Database Setup', 'description' => 'Set up the database schema and migrations.'],
            ['name' => 'API Development', 'description' => 'Create RESTful APIs for project management.'],
            ['name' => 'Frontend Integration', 'description' => 'Integrate the frontend with the backend.'],
            ['name' => 'Testing & Debugging', 'description' => 'Perform unit and integration testing.'],
            ['name' => 'User Authentication', 'description' => 'Implement login and registration features.'],
            ['name' => 'Deployment Setup', 'description' => 'Prepare the application for deployment.'],
        ];
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    
}
