<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColegioCandidato extends Model
{
    use HasFactory;

    protected $table = 'colegios_candidatos';
    protected $fillable = ['colegiado', 'profesion', 'candidatos_id', 'colegios_id'];
}
