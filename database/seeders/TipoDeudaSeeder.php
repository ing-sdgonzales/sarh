<?php

namespace Database\Seeders;

use App\Models\TipoDeuda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDeudaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_deudas = ['Banco', 'Prestamo', 'Vehículo', 'Otro'];

        foreach ($tipos_deudas as $tipo_deuda) {
            TipoDeuda::create([
                'tipo_deuda' => $tipo_deuda
            ]);
        }
    }
}
