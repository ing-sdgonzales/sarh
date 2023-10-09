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
            ['dn' => 4, 'sp' => 2],
            ['dn' => 5, 'sp' => 2],
            ['dn' => 6, 'sp' => 2],
            ['dn' => 7, 'sp' => 2],
            ['dn' => 8, 'sp' => 2],
            ['dn' => 9, 'sp' => 2],
            ['dn' => 10, 'sp' => 3],
            ['dn' => 11, 'sp' => 4],
            ['dn' => 12, 'sp' => 4],
            ['dn' => 13, 'sp' => 4],
            ['dn' => 14, 'sp' => 4],
            ['dn' => 15, 'sp' => 5],
            ['dn' => 16, 'sp' => 6],
            ['dn' => 16, 'sp' => 7],
            ['dn' => 17, 'sp' => 8],
            ['dn' => 18, 'sp' => 9],
            ['dn' => 18, 'sp' => 10],
            ['dn' => 19, 'sp' => 12],
            ['dn' => 19, 'sp' => 13],
            ['dn' => 19, 'sp' => 14],
            ['dn' => 20, 'sp' => 15],
            ['dn' => 21, 'sp' => 16],
            ['dn' => 21, 'sp' => 17],
            ['dn' => 22, 'sp' => 18]
        ];

        foreach ($dsData as $data) {
            DependenciaSubproducto::create([
                'dependencias_nominales_id' => $data['dn'],
                'subproductos_id' => $data['sp']
            ]);
        }
    }
}
