<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'username' => 'admin' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('PassWord!@' . str_pad($i, 3, '0', STR_PAD_LEFT)),
            ]);
        }
    }
}
