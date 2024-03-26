<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';
    protected $fillable = ['experiencia', 'descripcion', 'disponibilidad', 'estudios', 'registros_academicos_id', 'puestos_nominales_id'];
}
