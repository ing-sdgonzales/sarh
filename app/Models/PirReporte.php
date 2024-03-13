<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirReporte extends Model
{
    use HasFactory;

    protected $table = 'pir_reportes';
    protected $fillable = ['reporte'];
}
