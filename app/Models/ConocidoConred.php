<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConocidoConred extends Model
{
    use HasFactory;

    protected $table = 'conocidos_conred';
    protected $fillable = ['nombre', 'cargo', 'empleados_id'];
}
