<?php

namespace Database\Seeders;

use App\Models\PirSeccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PirSeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secciones = [
            'Comando', 'Información', 'Enlace', 'Seguridad', 'Jurídico', 'Protocólo', 'Inspectoría',
            'Auditoría', 'Operaciones Estrategícas', 'Operaciones Tácticas', 'Logística', 'Planificación',
            'Administración y Finanzas'
        ];

        foreach ($secciones as $seccion) {
            PirSeccion::create([
                'seccion' => $seccion
            ]);
        }
    }
}
