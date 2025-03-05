<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phase;
use App\Models\Task;
use App\Models\User;

class TaskPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tasks = Task::all();
        $phases = Phase::all();
        $admin = User::where('email', 'admin@gmail.com')->first(); // Fetch the admin user

        if (!$admin) {
            $this->command->error('Admin user not found. Make sure you seed users first.');
            return;
        }

        foreach ($tasks as $task) {
            $task->phases()->attach($phases->random(rand(1, 2))->pluck('id')->toArray(), [
                'created_by' => $admin->id, // Set the created_by column
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Task-Phase relationships created with created_by field.');
    }
}
