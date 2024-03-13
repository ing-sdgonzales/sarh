<?php

namespace Database\Seeders;

use App\Models\PirGrupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PirGrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = ['Alfa', 'Bravo', 'Echo', 'Enlace'];

        foreach ($grupos as $grupo) {
            PirGrupo::create([
                'grupo' => $grupo
            ]);
        }
    }
}
