<?php

namespace Database\Seeders;

use App\Models\TipoVehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_vehiculos = ['Camioneta', 'Hatchback', 'Motocicleta', 'Pick-up', 'Sedán'];

        foreach ($tipos_vehiculos as $tipo_vehiculo) {
            TipoVehiculo::create([
                'tipo_vehiculo' => $tipo_vehiculo
            ]);
        }
    }
}