<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependenciaSubproducto extends Model
{
    use HasFactory;

    protected $table = 'dependencias_subproductos';
    protected $fillable = ['dependencias_nominales_id', 'subproductos_id'];
}
