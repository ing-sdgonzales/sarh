<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionDisponible extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_disponibles';
    protected $fillable = ['year', 'dias_disponibles', 'empleados_id'];
}
