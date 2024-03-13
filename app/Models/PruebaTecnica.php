<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaTecnica extends Model
{
    use HasFactory;

    protected $table = 'pruebas_tecnicas';
    protected $fillable = ['prueba', 'nota', 'fecha', 'candidatos_id'];
    protected $casts = ['fecha' => 'datetime:Y-m-d'];
}
