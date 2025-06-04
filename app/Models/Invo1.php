<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invo1 extends Model
{
     protected $table = 'invo1';
    protected $primaryKey = 'nro';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
         'sta_invnr','pernr', 'custnr', 'ctotal', 'total', 'fecha',
        'obs', 'origen', 'facturar', 'saldo', 'depo', 'flag'
    ];//

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'custnr', 'custnr');
}

}
