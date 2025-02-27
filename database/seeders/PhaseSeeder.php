<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $phases = [
            ['name' => 'Planning', 'order' => 1],
            ['name' => 'Development', 'order' => 2],
            ['name' => 'Testing', 'order' => 3],
            ['name' => 'Deployment', 'order' => 4],
        ];

        foreach ($phases as $phase) {
            Phase::create($phase);
        }
    }
}
