<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoRenglon extends Model
{
    use HasFactory;

    protected $table = 'bonos_renglones';
    protected $fillable = ['renglones_id', 'bonificaciones_id'];
}
