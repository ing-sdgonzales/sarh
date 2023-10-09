<?php

namespace Database\Seeders;

use App\Models\Etnia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etniasData = [
            ['etnia' => 'Maya'],
            ['etnia' => 'Xinca'],
            ['etnia' => 'Garífuna'],
            ['etnia' => 'Ladino']
        ];

        foreach ($etniasData as $etnia) {
            Etnia::create([
                'etnia' => $etnia['etnia']
            ]);
        }
    }
}
