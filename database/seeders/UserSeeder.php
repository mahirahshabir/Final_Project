<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
         'name'=> 'Admin User',
         'email'=> 'admin@gmail.com',
         'password'=>'1234567'
     ]);

    }
}
