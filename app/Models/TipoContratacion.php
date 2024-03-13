<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContratacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_contrataciones';
    protected $fillable = ['tipo', 'observacion'];
}
