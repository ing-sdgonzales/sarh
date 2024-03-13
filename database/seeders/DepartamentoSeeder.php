<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentosData = [
            ['codigo' => '01', 'nombre' => 'Guatemala', 'regiones_id' => 1],
            ['codigo' => '02', 'nombre' => 'El Progreso', 'regiones_id' => 3],
            ['codigo' => '03', 'nombre' => 'Sacatepéquez', 'regiones_id' => 5],
            ['codigo' => '04', 'nombre' => 'Chimaltenango', 'regiones_id' => 5],
            ['codigo' => '05', 'nombre' => 'Escuintla', 'regiones_id' => 5],
            ['codigo' => '06', 'nombre' => 'Santa Rosa', 'regiones_id' => 4],
            ['codigo' => '07', 'nombre' => 'Sololá', 'regiones_id' => 6],
            ['codigo' => '08', 'nombre' => 'Totonicapán', 'regiones_id' => 6],
            ['codigo' => '09', 'nombre' => 'Quetzaltenango', 'regiones_id' => 6],
            ['codigo' => '10', 'nombre' => 'Suchitepéquez', 'regiones_id' => 6],
            ['codigo' => '11', 'nombre' => 'Retalhuleu', 'regiones_id' => 6],
            ['codigo' => '12', 'nombre' => 'San Marcos', 'regiones_id' => 6],
            ['codigo' => '13', 'nombre' => 'Huehuetenango', 'regiones_id' => 7],
            ['codigo' => '14', 'nombre' => 'Quiché', 'regiones_id' => 7],
            ['codigo' => '15', 'nombre' => 'Baja Verapaz', 'regiones_id' => 2],
            ['codigo' => '16', 'nombre' => 'Alta Verapaz', 'regiones_id' => 2],
            ['codigo' => '17', 'nombre' => 'Petén', 'regiones_id' => 8],
            ['codigo' => '18', 'nombre' => 'Izabal', 'regiones_id' => 3],
            ['codigo' => '19', 'nombre' => 'Zacapa', 'regiones_id' => 3],
            ['codigo' => '20', 'nombre' => 'Chiquimula', 'regiones_id' => 3],
            ['codigo' => '21', 'nombre' => 'Jalapa', 'regiones_id' => 4],
            ['codigo' => '22', 'nombre' => 'Jutiapa', 'regiones_id' => 4],
        ];

        foreach ($departamentosData as $departamentoData) {
            Departamento::create([
                'codigo' => $departamentoData['codigo'],
                'nombre' => $departamentoData['nombre'],
                'regiones_id' => $departamentoData['regiones_id'],
            ]);
        }
    }
}
