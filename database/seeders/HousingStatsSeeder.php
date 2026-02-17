<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HousingStat;
use App\Models\HousingNote;

class HousingStatsSeeder extends Seeder
{
    public function run(): void
    {
        // Seed default housing stats if table exists and is empty/partial
        $defaults = [
            ['label' => 'Jumlah Rumah', 'value' => 0, 'sort_order' => 1],
            ['label' => 'Backlog Penghunian', 'value' => 0, 'sort_order' => 2],
            ['label' => 'Backlog Kepemilikan', 'value' => 0, 'sort_order' => 3],
            ['label' => 'Jumlah RTLH', 'value' => 0, 'sort_order' => 4],
        ];

        foreach ($defaults as $row) {
            HousingStat::firstOrCreate(
                ['label' => $row['label']],
                ['value' => $row['value'], 'sort_order' => $row['sort_order']]
            );
        }

        // Ensure a HousingNote record exists
        if (!HousingNote::first()) {
            HousingNote::create(['content' => null]);
        }
    }
}