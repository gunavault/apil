<?php

namespace App\Http\Controllers;

use App\Kebun;
use App\Pemasok;
use Illuminate\Http\Request;

class KebunController extends Controller{

    public function getPlasma()
    {
        $plasma = Kebun::groupBy('kode_plasma')->pluck('kode_plasma');
        return $plasma;
    }
    public function getKebun($idPlasma)
    {
        $kebun = Kebun::where('kode_plasma',$idPlasma)->pluck('kode_kebun');
        return $kebun;
    }
    public function getJenis($idKebun)
    {
        $kebun = Pemasok::where('unit',$idKebun)->groupBy('jenis')->pluck('jenis');
        return $kebun;
    }
}

