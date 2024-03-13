<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcademico extends Model
{
    use HasFactory;

    protected $table = 'registros_academicos';
    protected $fillable = ['nivel'];
}
