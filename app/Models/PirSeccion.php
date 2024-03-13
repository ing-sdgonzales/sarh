<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirSeccion extends Model
{
    use HasFactory;
    protected $table = 'pir_secciones';
    protected $fillable = ['seccion'];
}
