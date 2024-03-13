<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    use HasFactory;

    protected $table = 'entrevistas';
    protected $fillable = ['observacion', 'candidatos_id', 'fecha_entrevista'];
    protected $casts = ['fecha_entrevista' => 'datetime:Y-m-d'];
}
