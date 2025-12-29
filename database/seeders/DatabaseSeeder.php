<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed admin user
        $this->call(AdminUserSeeder::class);
        
        // Seed essential skills
        $this->call(SkillSeeder::class);

        // Seed topics for categorization
        Topic::create(['title' => 'Web Development', 'description' => 'Frontend, Backend, Fullstack web applications']);
        Topic::create(['title' => 'Mobile Development', 'description' => 'Android, iOS, Cross-platform mobile apps']);
        Topic::create(['title' => 'UI/UX Design', 'description' => 'User Interface and User Experience design']);
        Topic::create(['title' => 'Data Science', 'description' => 'Machine Learning, Data Analysis, AI']);
        Topic::create(['title' => 'DevOps', 'description' => 'Deployment, CI/CD, Infrastructure']);
    }
}
