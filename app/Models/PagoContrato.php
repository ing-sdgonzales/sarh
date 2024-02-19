<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoContrato extends Model
{
    use HasFactory;

    protected $table = 'pagos_contratos';
    protected $fillable = ['salario', 'mes', 'primer_pago', 'periodos_contratos_id'];
}
