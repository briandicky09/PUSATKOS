<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            'WiFi',
            'AC',
            'Kamar Mandi Dalam',
            'Kasur',
            'Lemari',
            'Meja',
            'Kursi',
            'Parkir Motor',
            'Parkir Mobil',
            'Dapur',
            'CCTV',
            'Laundry',
            'Listrik',
        ];

        foreach ($facilities as $name) {
            Facility::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
