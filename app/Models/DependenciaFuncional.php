<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependenciaFuncional extends Model
{
    use HasFactory;

    protected $table = 'dependencias_funcionales';
    protected $fillable =  ['dependencia'];
}
