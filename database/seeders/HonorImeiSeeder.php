<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HonorImeiSeeder extends Seeder
{
    public function run(): void
    {
        $imeis = [
            '352099111111111',
            '352099111111112',
            '352099111111113',
            '352099111111114',
            '352099111111115',
            '352099111111116',
            '352099111111117',
            '352099111111118',
            '352099111111119',
            '352099111111120',
            '352099111111121',
            '352099111111122',
            '352099111111123',
            '352099111111124',
            '352099111111125',
        ];

        foreach ($imeis as $imei) {
            DB::table('honor_imei_list')->insert([
                'imei' => $imei,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
