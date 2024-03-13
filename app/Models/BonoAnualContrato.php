<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoAnualContrato extends Model
{
    use HasFactory;

    protected $table = 'bonos_anuales_contratos';
    protected $fillable = ['bono', 'cantidad', 'mes', 'periodos_contratos_id'];
}
