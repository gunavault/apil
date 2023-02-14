<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $table = 'harga_pembelian';
    public $timestamps = false;

    protected $primaryKey  = 'id';

    function pabrik(){
        return $this->belongsTo(Pabrik::class, 'id_pks_harga', 'id_pks_harga');
    }
}
