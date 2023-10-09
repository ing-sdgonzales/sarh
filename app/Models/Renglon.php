<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renglon extends Model
{
    use HasFactory;

    protected $table = 'renglones';
    protected $fillable = ['renglon', 'nombre', 'asignado', 'modificaciones', 'vigente', 'pre_comprometido', 'comprometido', 'devengado', 'pagado', 'saldo_por_comprometer', 'saldo_por_devengar', 'saldo_por_pagar', 'tipo'];
}
