<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['email' => 'kel.tallunglipu@admin.com', 'name' => 'Kelurahan Tallunglipu Admin', 'password' => 'kel.tallunglipu46'],
            ['email' => 'kel.tallunglipu', 'name' => 'Kelurahan Tallunglipu', 'password' => 'kel.tallunglipu46'],
            ['email' => 'disperkimtanlh@admin1', 'name' => 'Admin 1', 'password' => 'disperkimlhtan1'],
            ['email' => 'disperkimtanlh@admin2', 'name' => 'Admin 2', 'password' => 'disperkimlhtan2'],
            ['email' => 'disperkimtanlh@admin3', 'name' => 'Admin 3', 'password' => 'disperkimlhtan3'],
            ['email' => 'disperkimtanlh@admin4', 'name' => 'Admin 4', 'password' => 'disperkimlhtan4'],
            ['email' => 'disperkimtanlh@admin5', 'name' => 'Admin 5', 'password' => 'disperkimlhtan5'],
        ];

        foreach ($admins as $a) {
            // Upsert by email; update name, password, and is_admin each run
            $user = User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make($a['password']),
                    'is_admin' => true,
                    'email_verified_at' => null,
                ]
            );
        }
    }
}