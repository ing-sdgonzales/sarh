<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generosData = [
            ['genero' => 'Masculino'],
            ['genero' => 'Femenino']
        ];

        foreach ($generosData as $etnia) {
            Genero::create([
                'genero' => $etnia['genero']
            ]);
        }
    }
}
