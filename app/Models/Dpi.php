<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpi extends Model
{
    use HasFactory;

    protected $table = 'dpis';
    protected $fillable = ['dpi', 'municipios_id', 'empleados_id'];
}
