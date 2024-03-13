<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonoCandidato extends Model
{
    use HasFactory;

    protected $table = 'telefonos_candidatos';
    protected $fillable = ['telefono', 'candidatos_id'];
}
