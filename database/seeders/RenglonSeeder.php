<?php

namespace Database\Seeders;

use App\Models\Renglon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RenglonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $renglones = [
            ['renglon' => '011', 'nombre' => 'Personal permanente', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 0],
            ['renglon' => '012', 'nombre' => 'Complemento personal al salario del personal permanente', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '014', 'nombre' => 'Complemento por calidad profesional al personal permanente', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '015', 'nombre' => 'Complementos específicos al personal permanente', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '021', 'nombre' => 'Personal supernumerario', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 0],
            ['renglon' => '022', 'nombre' => 'Personal por contrato', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 0],
            ['renglon' => '025', 'nombre' => 'Complemento por antigüedad al personal temporal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '026', 'nombre' => 'Complemento por calidad profesional al personal temporal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '027', 'nombre' => 'Complementos específicos al personal temporal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '029', 'nombre' => 'Otras remuneraciones de personal temporal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 0],
            ['renglon' => '031', 'nombre' => 'Jornales', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 0],
            ['renglon' => '032', 'nombre' => 'Complemento por antigüedad al personal por jornal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '033', 'nombre' => 'Complementos específicos al personal por jornal', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '051', 'nombre' => 'Aporte patronal al IGSS', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '055', 'nombre' => 'Aporte para clases pasivas', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '063', 'nombre' => 'Gastos de representación en el interior', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '071', 'nombre' => 'Aguinaldo', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '072', 'nombre' => 'Bonificacion anual (Bono 14)', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1],
            ['renglon' => '073', 'nombre' => 'Bono Vacacional', 'asignado' => 0.00, 'modificaciones' => 0.00, 'vigente' => 0.00, 'pre_comprometido' => 0.00,  'comprometido' => 0.00, 'devengado' => 0.00, 'pagado' => 0.00, 'saldo_por_comprometer' => 0.00, 'saldo_por_devengar' => 0.00, 'saldo_por_pagar' => 0.00, 'tipo' => 1]
        ];

        foreach ($renglones as $renglon) {
            Renglon::create([
                'renglon' => $renglon['renglon'],
                'nombre' => $renglon['nombre'],
                'asignado' => $renglon['asignado'],
                'modificaciones' => $renglon['modificaciones'],
                'vigente' => $renglon['vigente'],
                'pre_comprometido' => $renglon['pre_comprometido'],
                'comprometido' => $renglon['comprometido'],
                'devengado' => $renglon['devengado'],
                'pagado' => $renglon['pagado'],
                'saldo_por_comprometer' => $renglon['saldo_por_comprometer'],
                'saldo_por_devengar' => $renglon['saldo_por_devengar'],
                'saldo_por_pagar' => $renglon['saldo_por_pagar'],
                'tipo' => $renglon['tipo']
            ]);
        }
    }
}
