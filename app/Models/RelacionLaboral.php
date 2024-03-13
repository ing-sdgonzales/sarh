<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionLaboral extends Model
{
    use HasFactory;

    protected $table = 'relaciones_laborales';
    protected $fillable = ['relacion_laboral'];
}
