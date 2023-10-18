<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaDependiente extends Model
{
    use HasFactory;

    protected $table = 'personas_dependientes';
    protected $fillable = ['nombre', 'parentesco', 'empleados_id'];
}
