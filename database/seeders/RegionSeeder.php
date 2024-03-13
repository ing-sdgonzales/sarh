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

        $regionesData = [
            ['region' => 'Región I', 'nombre' => 'Metropolitana'],
            ['region' => 'Región II', 'nombre' => 'Norte'],
            ['region' => 'Región III', 'nombre' => 'Nororiente'],
            ['region' => 'Región IV', 'nombre' => 'Suroriente'],
            ['region' => 'Región V', 'nombre' => 'Central'],
            ['region' => 'Región VI', 'nombre' => 'Suroccidente'],
            ['region' => 'Región VII', 'nombre' => 'Occidente'],
            ['region' => 'Región VIII', 'nombre' => 'Petén']
        ];

        foreach ($regionesData as $region) {
            Region::create([
                'region' => $region['region'],
                'nombre' => $region['nombre']
            ]);
        }
    }
}
