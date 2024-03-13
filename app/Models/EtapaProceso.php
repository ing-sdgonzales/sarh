<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapaProceso extends Model
{
    use HasFactory;

    protected $table = 'etapas_procesos';
    protected $fillable = ['etapa'];
}
