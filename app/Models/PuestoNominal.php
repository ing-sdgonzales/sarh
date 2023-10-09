<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoNominal extends Model
{
    use HasFactory;

    protected $table = 'puestos_nominales';
    protected $fillable = ['codigo', 'partida_presupuestaria', 'estado', 'cod_unidad_ejecutora', 'financiado', 'salario', 'fecha_registro', 
    'especialidades_id', 'renglones_id', 'plazas_id', 'fuentes_financiamientos_id', 'dependencias_nominales_id', 'municipios_id', 
    'catalogo_puestos_id', 'tipos_servicios_id'];
}
