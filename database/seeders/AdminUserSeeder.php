<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $username = sprintf('admin%03d', $i); // admin001, admin002, ...

            User::updateOrCreate(
                ['username' => $username],
                [
                    'password' => Hash::make($username), // p = admin001 ฯลฯ
                ]
            );
        }
    }
}
