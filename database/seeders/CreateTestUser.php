<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateTestUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'demo@code-lara.com',
                'password' => bcrypt('codelara123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
