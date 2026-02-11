<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // National
        $national = Region::create([
            'name' => 'Nasional',
            'level' => 'national',
        ]);

        // Province
        $jakarta = Region::create([
            'name' => 'DKI Jakarta',
            'level' => 'province',
            'parent_id' => $national->id,
        ]);

        $jabar = Region::create([
            'name' => 'Jawa Barat',
            'level' => 'province',
            'parent_id' => $national->id,
        ]);

        // Regency (Kota/Kab)
        $jaksel = Region::create([
            'name' => 'Jakarta Selatan',
            'level' => 'regency',
            'parent_id' => $jakarta->id,
        ]);

        $bogor = Region::create([
            'name' => 'Kabupaten Bogor',
            'level' => 'regency',
            'parent_id' => $jabar->id,
        ]);

        // District (Kecamatan)
        Region::create([
            'name' => 'Kebayoran Baru',
            'level' => 'district',
            'parent_id' => $jaksel->id,
        ]);

        Region::create([
            'name' => 'Cibinong',
            'level' => 'district',
            'parent_id' => $bogor->id,
        ]);
    }
}
