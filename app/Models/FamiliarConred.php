<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliarConred extends Model
{
    use HasFactory;

    protected $table = 'familiares_conred';
    protected $fillable = ['nombre', 'cargo', 'empleados_id'];
}
