<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invo2 extends Model
{
   protected $table = 'invo2';
    protected $primaryKey = 'nro';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'sta_invnr', 'item', 'qty', 'precio', 'subtotal',
        'fecha', 'costo','depo', 'origen','flag', 'descr'
    ]; //
}
