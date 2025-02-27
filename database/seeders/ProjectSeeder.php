<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //,
        $user = User::first();

        if ($user) {
            Project::create([
                'name' => 'Project Management System',
                'description' => 'A system to manage projects and tasks.',
                'manager_id' => $user->id, // Assign the first user's ID
            ]);
        } else {
            echo "No users found! Run UserSeeder first.\n";
        }
    }
}
