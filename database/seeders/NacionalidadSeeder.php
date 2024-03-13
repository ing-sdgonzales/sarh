<?php

namespace Database\Seeders;

use App\Models\Nacionalidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NacionalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nacionalidadData = [
            ['nacionalidad' => 'guatemalteco']
        ];

        foreach ($nacionalidadData as $nacionalidad) {
            Nacionalidad::create([
                'nacionalidad' => $nacionalidad['nacionalidad']
            ]);
        }
    }
}
