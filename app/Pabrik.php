<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Pabrik extends Model
{
    protected $table = 'pabrik';
    public $timestamps = false;

    public function sortasiPlasma(){
        return $this->hasMany(SortasiPlasma::class, 'kode_kebun', 'unit');
    }

    public function harga($tanggal){
        return $this->hasMany(Harga::class, 'id_pks_harga', 'id_pks_harga')->where('tanggal', $tanggal);
    }
}
