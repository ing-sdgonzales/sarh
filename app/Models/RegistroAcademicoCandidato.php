<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcademicoCandidato extends Model
{
    use HasFactory;

    protected $table = 'registros_academicos_candidatos';
    protected $fillable = ['estado', 'profesion', 'candidatos_id', 'registros_academicos_id'];

}
