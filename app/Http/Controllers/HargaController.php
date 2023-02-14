<?php

namespace App\Http\Controllers;
use DB;
use App\Harga;
use App\Pabrik;
use App\SortasiPlasma;
use Illuminate\Http\Request;

class HargaController extends Controller{
    public function index(Request $request, $kode_plasma)
    {
        if ($kode_plasma == 'all'){
            $sortasiPlasma = Pabrik::join('harga_pembelian','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('tanggal', date('Y-m-d'))
                ->get(['nama', 'unit', 'plasma', 'lat', 'long', 'kapasitas', 'keterangan',
                    'id_transaksi', 'tanggal', 'harga', 'tahun']);

            $inti = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('tanggal', date('Y-m-d'))
                ->where('keterangan', 'inti')
                ->avg('harga')) ?: 0;

            $pesaing = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('tanggal', date('Y-m-d'))
                ->where('keterangan', 'pesaing')
                ->avg('harga')) ?: 0;


            $lastInti = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('tanggal', date('Y-m-d',strtotime("-1 days")))
                ->where('keterangan', 'inti')
                ->avg('harga')) ?: 0;

            $lastPesaing = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('tanggal', date('Y-m-d',strtotime("-1 days")))
                ->where('keterangan', 'pesaing')
                ->avg('harga')) ?: 0;
        }
        else{
            $sortasiPlasma = Pabrik::join('harga_pembelian','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('plasma',$kode_plasma)
                ->where('tanggal', date('Y-m-d'))
                ->get(['nama', 'unit', 'plasma', 'lat', 'long', 'kapasitas', 'keterangan',
                    'id_transaksi', 'tanggal', 'harga', 'tahun']);

            $inti = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('plasma',$kode_plasma)
                ->where('tanggal', date('Y-m-d'))
                ->where('keterangan', 'inti')
                ->avg('harga')) ?: 0;

            $pesaing = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('plasma',$kode_plasma)
                ->where('tanggal', date('Y-m-d'))
                ->where('keterangan', 'pesaing')
                ->avg('harga')) ?: 0;

            $lastInti = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('plasma',$kode_plasma)
                ->where('tanggal', date('Y-m-d',strtotime("-1 days")))
                ->where('keterangan', 'inti')
                ->avg('harga')) ?: 0;

            $lastPesaing = intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                ->where('plasma',$kode_plasma)
                ->where('tanggal', date('Y-m-d',strtotime("-1 days")))
                ->where('keterangan', 'pesaing')
                ->avg('harga')) ?: 0;
        }

        $listHarga=array();
        $month = date('m');
        $year = date('Y');
        $a = date('d');

        for($d=1; $d<=$a; $d++)
        {
            $b = array();
            $time=mktime(12, 0, 0, $month, $d, $year);
                $tanggal = date('Y-m-d', $time);
                $b['tanggal']=date('d', $time);
                $b['plasma']=intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                    ->where('tanggal', $tanggal)
                    ->where('keterangan', 'inti')
                    ->avg('harga')) ?: 0;
                $b['pesaing']=intval(Harga::join('pabrik','pabrik.id_pks_harga', '=','harga_pembelian.id_pks_harga')
                    ->where('tanggal', $tanggal)
                    ->where('keterangan', 'pesaing')
                    ->avg('harga')) ?: 0;
                array_push($listHarga,$b);
        }

        $geoJSON = [];
        $geoJSON['type']='FeatureCollection';
        foreach($sortasiPlasma as $p){
            $data = [
                'type' => 'Feature',
                'properties'=> [
                    'nama'=>$p->nama,
                    'unit'=>$p->unit,
                    'plasma'=>$p->plasma,
                    'kapasitas'=>$p->kapasitas,
                    'keterangan'=>$p->keterangan,
                    'harga'=>$p->harga,
                ]
                ,
                'geometry'=>[
                    'type'=>'Point',
                    'coordinates'=>[$p->lat,$p->long]
                ],
            ];
            $geoJSON['nowInti']=$inti;
            $geoJSON['nowPesaing']=$pesaing;
            $geoJSON['lastInti']=$lastInti;
            $geoJSON['lastPesaing']=$lastPesaing;

            $geoJSON['features'][]=$data;
            $geoJSON['listHarga']=$listHarga;
        }
        return response()->json($geoJSON);
    }

    public function reportHarga(Request $request, $kode_plasma)
    {
        $str = $request->tanggal_start?:date('Y-m-d');
        $end = $request->tanggal_end?:date('Y-m-d');
        $keySearch = $request->q?: null;

        if ($keySearch == null){
            if ($kode_plasma == 'all'){
                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
                    ->whereBetween('tanggal', [$str, $end])
                    ->get();
            }
            else {
                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
                    ->whereBetween('tanggal', [$str, $end])
                    ->where('id_transaksi','LIKE','%'.$kode_plasma.'%')
                    ->get(['nama', 'unit', 'plasma', 'keterangan', 'id_transaksi', 'tanggal', 'harga',
                        'tahun', 'created_at', 'update_at']);
            }
        }

        if ($keySearch != null){
            if ($kode_plasma == 'all'){
                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
                    ->whereBetween('tanggal', [$str, $end])
                    ->get();
            }
            else {
                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
                    ->whereBetween('tanggal', [$str, $end])
                    ->where('id_transaksi','LIKE','%'.$kode_plasma.'%')
                    ->get(['nama', 'unit', 'plasma', 'keterangan', 'id_transaksi', 'tanggal', 'harga',
                        'tahun', 'created_at', 'update_at']);
            }
        }


        return json_encode($harga);

//        $tanggal = date('Y-m-d');
//        $harga = null;
//        if ($kode_plasma != 'all' && $kode_plasma != null){
//            if($request->tanggal_start){
//                $tanggal = $request->tanggal_start;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('plasma',$kode_plasma)->where('tanggal','=',$tanggal)->get();
//            }
//            if($request->tanggal_end){
//                $tanggal = $request->tanggal_end;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('plasma',$kode_plasma)->where('tanggal','=',$tanggal)->get();
//            }
//
//            if(isset($request->q)){
//                $q = $request->q;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('plasma',$kode_plasma)
//                        ->where('id_transaksi','like',"%${q}%")
//                        ->orWhere('tanggal','like',"%${q}%")
//                        ->orWhere('harga','like',"%${q}%")
//                        ->orWhere('tahun','like',"%${q}%")
//                        ->orWhere('nama','like',"%${q}%")
//                        ->orWhere('unit','like',"%${q}%")
//                        ->orWhere('plasma','like',"%${q}%")
//                        ->orWhere('kapasitas','like',"%${q}%")
//                        ->orWhere('keterangan','like',"%${q}%")->get();
//            }
//        }
//
//        if ($kode_plasma == 'all'){
//            if($request->tanggal_start){
//                $tanggal = $request->tanggal_start;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('tanggal','=',$tanggal)->get();
//            }
//            if($request->tanggal_end){
//                $tanggal = $request->tanggal_end;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('plasma',$kode_plasma)->where('tanggal','=',$tanggal)->get();
//            }
//            if(isset($request->q)){
//                $q = $request->q;
//                $harga = Harga::join('pabrik','harga_pembelian.id_pks_harga', '=','pabrik.id_pks_harga')
//                    ->where('id_transaksi','like',"%${q}%")
//                    ->orWhere('tanggal','like',"%${q}%")
//                    ->orWhere('harga','like',"%${q}%")
//                    ->orWhere('tahun','like',"%${q}%")
//                    ->orWhere('nama','like',"%${q}%")
//                    ->orWhere('unit','like',"%${q}%")
//                    ->orWhere('plasma','like',"%${q}%")
//                    ->orWhere('kapasitas','like',"%${q}%")
//                    ->orWhere('keterangan','like',"%${q}%")->get();
//            }
//        }
//
//        return response()->json($harga);
    }

}
