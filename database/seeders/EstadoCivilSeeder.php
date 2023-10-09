<?php

namespace Database\Seeders;

use App\Models\EstadoCivil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadosData = ['soltero(a)', 'casado(a)'];

        foreach ($estadosData as $ec) {
            EstadoCivil::create([
                'estado_civil' => $ec
            ]);
        }
    }
}
