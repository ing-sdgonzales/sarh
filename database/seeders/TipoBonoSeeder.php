<?php

namespace Database\Seeders;

use App\Models\TipoBonificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoBonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_bonos = ['Mensual', 'Anual'];

        foreach ($tipos_bonos as $tipo_bono) {
            TipoBonificacion::create([
                'tipo_bonificacion' => $tipo_bono
            ]);
        }
    }
}
