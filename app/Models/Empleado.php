<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $fillable = [
        'codigo', 'nit', 'igss', 'imagen', 'nombres', 'apellidos', 'email', 'fecha_ingreso',
        'fecha_nacimiento', 'cuenta_banco', 'fecha_retiro', 'estado', 'estado_familiar', 'pretension_salarial',
        'observaciones', 'estudia_actualmente', 'estudio_actual', 'cantidad_personas_dependientes', 'ingresos_adicionales',
        'monto_ingreso_total', 'posee_deudas', 'trabajo_conred', 'trabajo_estado', 'jubilado_estado', 'institucion_jubilacion',
        'personas_aportan_ingresos', 'fuente_ingresos_adicionales', 'pago_vivienda', 'familiar_conred', 'conocido_conred',
        'otro_etnia', 'generos_id', 'etnias_id', 'grupos_sanguineos_id', 'municipios_id',
        'tipos_lincencias_id', 'nacionalidades_id', 'tipos_viviendas_id', 'estados_civiles_id', 'regiones_id', 'candidatos_id'
    ];
}
