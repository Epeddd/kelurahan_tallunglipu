<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfografisSeeder extends Seeder
{
    public function run(): void
    {
        $wilayahs = [
            "Bo'ne Randanan",
            "Bo'ne Limbong",
            "Bo'ne Matampu' Utara",
            "Bo'ne Matampu' Selatan"
        ];

        foreach ($wilayahs as $w) {
            DB::table('infografis')->insert([
                'wilayah' => $w,
                'penduduk_tetap' => 0,
                'penduduk_non_tetap' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
