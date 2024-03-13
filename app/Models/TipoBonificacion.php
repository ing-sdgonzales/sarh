<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBonificacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_bonificaciones';
    protected $fillable = ['tipo_bonificacion'];
}
