<?php

namespace Database\Seeders;

use App\Models\GrupoSanguineo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSanguineoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gsData = [
            ['grupo' => 'A+'],
            ['grupo' => 'B+'],
            ['grupo' => 'AB+'],
            ['grupo' => 'AB-'],
            ['grupo' => 'A-'],
            ['grupo' => 'B-'],
            ['grupo' => 'O+'],
            ['grupo' => 'O-']
        ];

        foreach ($gsData as $grupo) {
            GrupoSanguineo::create([
                'grupo' => $grupo['grupo']
            ]);
        }
    }
}
