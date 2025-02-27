<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //,
        $projects = [
            ['name' => 'Project Management System', 'description' => 'A system to manage projects and tasks.'],
            ['name' => 'E-Commerce Platform', 'description' => 'An online marketplace for products and services.'],
            ['name' => 'HR Management System', 'description' => 'A system to manage employees and payroll.'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
      }
    }
}
