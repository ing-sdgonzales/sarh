<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoEmergencia extends Model
{
    use HasFactory;

    protected $table = 'contactos_emergencias';
    protected $fillable = ['nombre', 'direccion', 'telefono', 'empleados_id'];
}
