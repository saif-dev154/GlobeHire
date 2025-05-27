<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JobSeeder extends Seeder
{
    public function run()
    {
        DB::table('jobs')->insert([
            [
                'employer_id' => 3,
                'agent_ids' => json_encode([5, 6]),
                'required_skills' => json_encode(['PHP', 'Laravel', 'MySQL']),
                'title' => 'Backend Developer',
                'location' => 'Port Louis',
                'description' => 'Develop and maintain server-side applications using Laravel.',
                'salary' => 75000.00,
                'salary_structure' => 'monthly',
                'job_type' => 'Full-time',
                'experience_level' => 'Mid-level',
                'education' => 'Bachelor in Computer Science',
                'status' => 'active',
                'application_start_date' => Carbon::now()->toDateString(),
                'application_deadline' => Carbon::now()->addDays(30)->toDateString(),
                'gender' => 'any',
                'visa_sponsor' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employer_id' => 4,
                'agent_ids' => json_encode([5]),
                'required_skills' => json_encode(['React', 'JavaScript', 'HTML']),
                'title' => 'Frontend Engineer',
                'location' => 'Curepipe',
                'description' => 'Design and build responsive user interfaces.',
                'salary' => 68000.00,
                'salary_structure' => 'monthly',
                'job_type' => 'Contract',
                'experience_level' => 'Entry-level',
                'education' => 'Diploma in Web Development',
                'status' => 'pending',
                'application_start_date' => Carbon::now()->toDateString(),
                'application_deadline' => Carbon::now()->addDays(20)->toDateString(),
                'gender' => 'female',
                'visa_sponsor' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employer_id' => 3,
                'agent_ids' => json_encode([6]),
                'required_skills' => json_encode(['Python', 'Data Analysis', 'SQL']),
                'title' => 'Data Analyst',
                'location' => 'Quatre Bornes',
                'description' => 'Interpret data, analyze results using statistical techniques.',
                'salary' => 85000.00,
                'salary_structure' => 'monthly',
                'job_type' => 'Remote',
                'experience_level' => 'Senior',
                'education' => 'Masters in Data Science',
                'status' => 'closed',
                'application_start_date' => Carbon::now()->subDays(60)->toDateString(),
                'application_deadline' => Carbon::now()->subDays(30)->toDateString(),
                'gender' => 'male',
                'visa_sponsor' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
