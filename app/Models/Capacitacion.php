<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    use HasFactory;

    protected $table = 'capacitaciones';
    protected $fillable = ['capacitacion', 'capacitador', 'dependencias_nominales_id'];
}
