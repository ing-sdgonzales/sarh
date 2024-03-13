<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InduccionPendiente extends Model
{
    use HasFactory;

    protected $table = 'inducciones_pendientes';
    protected $fillable = ['pendiente', 'empleados_id'];
}
