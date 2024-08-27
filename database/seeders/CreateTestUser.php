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
        $test_users = [
            [
                'name' => 'Test User',
                'email' => 'demo@code-lara.com',
                'password' => bcrypt('codelara123'),
            ],
        ];

        foreach ($test_users as $test_user) {
            $user = User::where('email', $test_user['email'])->first();
            if (! empty($user)) {
                continue;
            }
            User::create($test_user);
        }
    }
}
