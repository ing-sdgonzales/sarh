<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subproducto extends Model
{
    use HasFactory;

    protected $table = 'subproductos';
    protected $fillable = ['codigo', 'proyecto', 'productos_id'];
}
