<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            ['name' => 'HTML', 'category' => 'Frontend'],
            ['name' => 'CSS', 'category' => 'Frontend'],
            ['name' => 'JavaScript', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'Vue.js', 'category' => 'Frontend'],
            ['name' => 'Angular', 'category' => 'Frontend'],
            ['name' => 'Node.js', 'category' => 'Backend'],
            ['name' => 'PHP', 'category' => 'Backend'],
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'Python', 'category' => 'Backend'],
            ['name' => 'Java', 'category' => 'Backend'],
            ['name' => 'UI Design', 'category' => 'Design'],
            ['name' => 'UX Design', 'category' => 'Design'],
            ['name' => 'Figma', 'category' => 'Design'],
            ['name' => 'Data Structures', 'category' => 'Programming'],
            ['name' => 'Algorithms', 'category' => 'Programming'],
            ['name' => 'C++', 'category' => 'Programming'],
            ['name' => 'Flutter', 'category' => 'Mobile'],
            ['name' => 'Dart', 'category' => 'Mobile'],
            ['name' => 'Mobile Development', 'category' => 'Mobile'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}