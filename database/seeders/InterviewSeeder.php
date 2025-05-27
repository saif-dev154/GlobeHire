<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InterviewSeeder extends Seeder
{
    public function run()
    {
        DB::table('interviews')->insert([
            [
                'application_id' => 1,
                'agent_id' => 5,
                'interview_date' => Carbon::now()->addDays(3)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'meeting_link' => 'https://zoom.us/j/1234567890',
                'status' => 'pending',
                'remarks' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'application_id' => 2,
                'agent_id' => 6,
                'interview_date' => Carbon::now()->addDays(5)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '14:45:00',
                'meeting_link' => 'https://meet.google.com/abc-defg-hij',
                'status' => 'pass',
                'remarks' => 'Strong communication skills, recommended for next round',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'application_id' => 3,
                'agent_id' => 5,
                'interview_date' => Carbon::now()->subDays(2)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/xyz',
                'status' => 'fail',
                'remarks' => 'Lacks required technical knowledge',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
