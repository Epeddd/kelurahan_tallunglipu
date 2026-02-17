<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Berita;
use App\Models\Agenda;

class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Categories
        $catNames = ['Perumahan', 'Permukiman', 'Lingkungan Hidup', 'Pertanahan'];
        $cats = collect($catNames)->map(function($name){
            return ServiceCategory::firstOrCreate(['slug'=>Str::slug($name)], ['name'=>$name]);
        });

        // Services
        foreach ($cats as $cat) {
            Service::firstOrCreate(
                ['slug' => Str::slug('Layanan '.$cat->name)],
                [
                    'category_id' => $cat->id,
                    'title' => 'Layanan '.$cat->name,
                    'description' => 'Deskripsi singkat layanan '.$cat->name,
                    'requirements' => ['KTP','KK','Formulir permohonan'],
                    'status' => 'active',
                ]
            );
        }

        // Berita
        Berita::factory()->count(3)->create([
            'status' => 'published',
            'author_id' => $admin->id,
            'published_at' => now()->subDays(2),
        ]);

        // Agenda
        Agenda::firstOrCreate([
            'title' => 'Rapat Koordinasi Bulanan',
        ], [
            'description' => 'Koordinasi lintas bidang',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3)->addHours(2),
            'location' => 'Kantor DISPERKIMTAN-LH',
            'status' => 'published',
        ]);
    }
}