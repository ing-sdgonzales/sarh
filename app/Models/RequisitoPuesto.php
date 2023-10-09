<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitoPuesto extends Model
{
    use HasFactory;

    protected $table = 'requisitos_puestos';
    protected $fillable = ['puestos_nominales_id', 'requisitos_id'];
}
