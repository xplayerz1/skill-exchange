<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@skillexchange.test')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@skillexchange.test',
                'password' => Hash::make('password'), 
                'role' => 'admin', 
                'department' => 'IT', 
                'batch' => '2020',    
            ]);

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }

}