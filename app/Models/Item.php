<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item'; // Si el campo se llama así
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'item', 'descri', 'precio', 'stock', 'depo', 'scode1', 'costo', 'tipo'
    ];//
}
