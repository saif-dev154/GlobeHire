<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ContractSeeder extends Seeder
{
    public function run()
    {
        DB::table('contracts')->insert([
            [
                'interview_id' => 1,
                'employer_id' => 4,
                'start_date' => Carbon::now()->addMonth()->toDateString(),
                'salary' => '40000',
                'working_hours' => '9am - 5pm, Mon-Fri',
                'leave_entitlement' => '21 days annual leave',
                'termination_terms' => 'Termination with 1 month notice',
                'notice_period' => '1 month',
                'jurisdiction' => 'Mauritius',
                'deadline' => Carbon::now()->addDays(15)->toDateString(),
                'contract_date' => Carbon::now()->toDateString(),
                'body' => 'This contract outlines the terms and conditions of employment...',
                'signature_path' => 'signatures/contract_1_signature.png',
                'status' => 'created',
                'remarks' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'interview_id' => 2,
                'employer_id' => 4,
                'start_date' => Carbon::now()->addWeeks(2)->toDateString(),
                'salary' => '50000',
                'working_hours' => 'Flexible, 40 hours/week',
                'leave_entitlement' => '15 days annual leave',
                'termination_terms' => 'Termination requires 2 weeks notice',
                'notice_period' => '2 weeks',
                'jurisdiction' => 'Mauritius',
                'deadline' => Carbon::now()->addDays(20)->toDateString(),
                'contract_date' => Carbon::now()->toDateString(),
                'body' => 'Employee agrees to the following terms...',
                'signature_path' => null,
                'status' => 'signed',
                'remarks' => 'Signed by candidate on 2025-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'interview_id' => 3,
                'employer_id' => 3,
                'start_date' => Carbon::now()->addMonths(2)->toDateString(),
                'salary' => '45000',
                'working_hours' => '10am - 6pm, Mon-Fri',
                'leave_entitlement' => '18 days annual leave',
                'termination_terms' => 'Immediate termination upon breach',
                'notice_period' => '1 month',
                'jurisdiction' => 'Mauritius',
                'deadline' => Carbon::now()->addDays(10)->toDateString(),
                'contract_date' => Carbon::now()->toDateString(),
                'body' => 'Contract terms as discussed during interview...',
                'signature_path' => null,
                'status' => 'approved',
                'remarks' => 'Approved by employer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
