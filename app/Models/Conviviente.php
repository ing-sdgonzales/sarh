<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conviviente extends Model
{
    use HasFactory;

    protected $table = 'convivientes';
    protected $fillable = ['nombre', 'ocupacion', 'telefono', 'empleados_id'];
}
