<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependenciaNominal extends Model
{
    use HasFactory;

    protected $table = 'dependencias_nominales';
    protected $fillable = ['dependencia', 'subproductos_id'];
}
