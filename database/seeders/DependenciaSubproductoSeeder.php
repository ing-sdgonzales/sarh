<?php

namespace Database\Seeders;

use App\Models\DependenciaSubproducto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DependenciaSubproductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dsData = [
            ['dn' => 1, 'sp' => 1],
            ['dn' => 2, 'sp' => 1],
            ['dn' => 3, 'sp' => 1],
            ['dn' => 23, 'sp' => 2],
            ['dn' => 22, 'sp' => 2],
            ['dn' => 18, 'sp' => 2],
            ['dn' => 20, 'sp' => 2],
            ['dn' => 4, 'sp' => 2],
            ['dn' => 11, 'sp' => 2],
            ['dn' => 21, 'sp' => 3],
            ['dn' => 8, 'sp' => 4],
            ['dn' => 10, 'sp' => 4],
            ['dn' => 6, 'sp' => 4],
            ['dn' => 5, 'sp' => 4],
            ['dn' => 7, 'sp' => 5],
            ['dn' => 12, 'sp' => 6],
            ['dn' => 12, 'sp' => 7],
            ['dn' => 13, 'sp' => 8],
            ['dn' => 14, 'sp' => 9],
            ['dn' => 14, 'sp' => 10],
            ['dn' => 15, 'sp' => 12],
            ['dn' => 15, 'sp' => 13],
            ['dn' => 15, 'sp' => 14],
            ['dn' => 16, 'sp' => 15],
            ['dn' => 17, 'sp' => 16],
            ['dn' => 17, 'sp' => 17],
            ['dn' => 19, 'sp' => 18]
        ];

        foreach ($dsData as $data) {
            DependenciaSubproducto::create([
                'dependencias_nominales_id' => $data['dn'],
                'subproductos_id' => $data['sp']
            ]);
        }
    }
}
