<?php

namespace Database\Seeders;

use App\Models\TipoServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviciosData = ['Servicios Técnicos', 'Servicios Profesionales'];

        foreach ($serviciosData as $servicio) {
            TipoServicio::create([
                'tipo_servicio' => $servicio
            ]);
        }
    }
}
