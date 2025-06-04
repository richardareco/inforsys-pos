<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   protected $table = 'cliente';
    protected $primaryKey = 'nro';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
         'custname', 'telef1', 'latitud', 'longitud', 'ruc'
    ];  
}
