<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoPuesto extends Model
{
    use HasFactory;

    protected $table = 'bonos_puestos';
    protected $fillable = ['cantidad', 'bonificaciones_id', 'puestos_nominales_id'];
}
