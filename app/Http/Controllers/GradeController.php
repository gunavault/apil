<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller{
//    kondisi di update dan delete belum ditambahin
//     1. kalau id nya tidak ditemukan
//     2. kalau parameter nya kosong
//     3. kalau ada error jaringan / server

    public function index(Request $request)
    {
        $pp = 1;
        $grade = new Grade;
        if($request->pp){
            $pp = $request->pp;
        }
        if(isset($request->q)){
            $q = $request->q;
            $grade = $grade->where('grade','like',"%${q}%")->orWhere('grade','like',"%${q}%")
                ->orWhere('unit','like',"%${q}%")
                ->orWhere('jenis','like',"%${q}%")
                ->orWhere('tenera_min','like',"%${q}%")
                ->orWhere('tenera_max','like',"%${q}%")
                ->orWhere('dura_min','like',"%${q}%")
                ->orWhere('dura_max','like',"%${q}%");
        }
        $grade = $grade->paginate($pp)->withQueryString();
        return response()->json($grade);
    }

    public function update(Request $request,$id)
    {
        //alur nya gini
        //1. grade lama di update status nya jadi NONAKTIF
        //2. grade yang diubah di insert jadi status nya AKTIF

        $grade = Grade::find($id);
        $grade->grade = $request->grade;
        $grade->unit = $request->unit;
        $grade->jenis = $request->jenis;
        $grade->tenera_min = $request->tenera_min;
        $grade->tenera_max = $request->tenera_max;
        $grade->dura_min = $request->dura_min;
        $grade->dura_max = $request->dura_max;
        $grade->save();
        return [
            "sukses"=>true,
            "data"=>$grade,
        ];
    }

    public function delete($id)
    {
        $grade = Grade::find($id);
        $grade->delete();
        return [
            "sukses"=>true
        ];
    }
}
