<?php

namespace App\Http\Controllers;

use App\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller{
    public function index(Request $request)
    {
        $pp = 1;
        $grade = new Pemasok();
        if($request->pp){
            $pp = $request->pp;
        }
        if(isset($request->q)){
            $q = $request->q;
            $grade = $grade->where('nama','like',"%${q}%")->orWhere('jenis','like',"%${q}%")
                ->orWhere('unit','like',"%${q}%")
                ->orWhere('plasma','like',"%${q}%")
                ->orWhere('suppliercode','like',"%${q}%");
        }
        $grade = $grade->paginate($pp)->withQueryString();
        return response()->json($grade);
    }

    public function update(Request $request,$id)
    {
        $pemasok = Pemasok::find($id);
        $pemasok->nama = $request->nama;
        $pemasok->jenis = $request->jenis;
        $pemasok->plasma = $request->rayon;
        $pemasok->unit = $request->unit;
        $pemasok->suppliercode = $request->suppliercode;
        $pemasok->save();
        return [
            "sukses"=>true,
            "data"=>$pemasok,
        ];
    }

    public function delete($id)
    {
        $pemasok = Pemasok::find($id);
        $pemasok->delete();
        return [
            "sukses"=>true
        ];
    }
}
