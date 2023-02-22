<?php

namespace App\Http\Controllers;

use App\Exports\SortasiPlasmaExport;
use App\SortasiPlasma;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class SortasiPlasmaController extends Controller{
    public function index(Request $request, $kode_plasma)
    {
        $tanggal = date('Y-m-d');
        $sortasiPlasma = new SortasiPlasma();
        if ($kode_plasma != 'all' && $kode_plasma != NULL){
            if($request->tanggal_start){
                $tanggal = $request->tanggal_start;
                $sortasiPlasma = $sortasiPlasma
                    ->where('kode_plasma',$kode_plasma)->where('tanggal','>=',$tanggal);
            }
            if($request->tanggal_end){
                $tanggal = $request->tanggal_end;
                $sortasiPlasma = $sortasiPlasma
                    ->where('kode_plasma',$kode_plasma)->where('tanggal','<=',$tanggal);
            }
            if(isset($request->q)){
                $q = $request->q;
                $sortasiPlasma = $sortasiPlasma->where(function($sp) use ($q, $kode_plasma){
                    $sp->where('kode_plasma',$kode_plasma)->where('no_ticket','like',"%${q}%")
                        ->orWhere('kode_kebun','like',"%${q}%")
                        ->orWhere('kode_plasma','like',"%${q}%")
                        ->orWhere('jenis','like',"%${q}%")
                        ->orWhere('masuk','like',"%${q}%")
                        ->orWhere('keluar','like',"%${q}%")
                        ->orWhere('durasi','like',"%${q}%")
                        ->orWhere('pemasok','like',"%${q}%")
                        ->orWhere('nopol','like',"%${q}%")
                        ->orWhere('jenis_truck','like',"%${q}%")
                        ->orWhere('supir','like',"%${q}%")
                        ->orWhere('bruto','like',"%${q}%")
                        ->orWhere('grade','like',"%${q}%")
                        ->orWhere('potongan','like',"%${q}%");
                });

            }
        }

        if ($kode_plasma == 'all'){
            if($request->tanggal_start){
                $tanggal = $request->tanggal_start;
                $sortasiPlasma = $sortasiPlasma
                    ->where('tanggal','>=',$tanggal);
            }
            if($request->tanggal_end){
                $tanggal = $request->tanggal_end;
                $sortasiPlasma = $sortasiPlasma
                    ->where('tanggal','<=',$tanggal);
            }
            if(isset($request->q)){
                $q = $request->q;
                $sortasiPlasma = $sortasiPlasma->where(function($sp) use ($q, $kode_plasma){
                    $sp->where('no_ticket','like',"%${q}%")
                        ->orWhere('kode_kebun','like',"%${q}%")
                        ->orWhere('kode_plasma','like',"%${q}%")
                        ->orWhere('jenis','like',"%${q}%")
                        ->orWhere('masuk','like',"%${q}%")
                        ->orWhere('keluar','like',"%${q}%")
                        ->orWhere('durasi','like',"%${q}%")
                        ->orWhere('pemasok','like',"%${q}%")
                        ->orWhere('nopol','like',"%${q}%")
                        ->orWhere('jenis_truck','like',"%${q}%")
                        ->orWhere('supir','like',"%${q}%")
                        ->orWhere('bruto','like',"%${q}%")
                        ->orWhere('grade','like',"%${q}%")
                        ->orWhere('potongan','like',"%${q}%");
                });
            }
        }
        $sortasiPlasma = $sortasiPlasma->get();

        return response()->json($sortasiPlasma);
    }

    //export
    public function export(Request $request)
    {
        return Excel::download(new SortasiPlasmaExport, 'sortasi_plasma.xlsx');
    }

    // tbsDipulangkan
    public function tbsDipulangkan(Request $request, $id_rekap){

        $sortasiPlasma = SortasiPlasma::where('id_rekap', $id_rekap)->get();

//        return $sortasiPlasma[0]['status'];
        $sortasiPlasma[0]->status = '5';
        $sortasiPlasma[0]->catatan  = $request->catatanss;
        $sortasiPlasma[0]->save();
        return [
            "sukses"=>true,
            "data"=>$sortasiPlasma,
        ];
    }

    // Sinkron data
    public function syncData(){
        return null;
    }

}
