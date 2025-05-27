<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admins
        User::create([
            'id' => 1,
            'name' => 'Admin One',
            'email' => 'a1@a',
            'password' => Hash::make('a1'),
            'role' => 'admin',
            'status' => 'active'
        ]);
        User::create([
            'id' => 2,
            'name' => 'Admin Two',
            'email' => 'a2@a',
            'password' => Hash::make('a2'),
            'role' => 'admin',
            'status' => 'active'
        ]);

        // Employers
        User::create([
            'id' => 3,
            'name' => 'Emp One',
            'email' => 'e1@e',
            'password' => Hash::make('e1'),
            'role' => 'employer',
            'status' => 'active'
        ]);
        User::create([
            'id' => 4,
            'name' => 'Emp Two',
            'email' => 'e2@e',
            'password' => Hash::make('e2'),
            'role' => 'employer',
            'status' => 'active'
        ]);

        // Agents
        User::create([
            'id' => 5,
            'name' => 'Agent One',
            'email' => 'ag1@a',
            'password' => Hash::make('ag1'),
            'role' => 'agent',
            'status' => 'active'
        ]);
        User::create([
            'id' => 6,
            'name' => 'Agent Two',
            'email' => 'ag2@a',
            'password' => Hash::make('ag2'),
            'role' => 'agent',
            'status' => 'active'
        ]);

        // Candidates
        User::create([
            'id' => 7,
            'name' => 'Cand One',
            'email' => 'c1@c',
            'password' => Hash::make('c1'),
            'role' => 'candidate',
            'status' => 'active'
        ]);
        User::create([
            'id' => 8,
            'name' => 'Cand Two',
            'email' => 'c2@c',
            'password' => Hash::make('c2'),
            'role' => 'candidate',
            'status' => 'active'
        ]);
    }
}
