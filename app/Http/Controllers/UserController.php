<?php

namespace App\Http\Controllers;

use App\Pabrik;
use App\SortasiPlasma;


class UserController extends Controller{
    private $defaultplasma = array("SGH", "SBT", "TPU", "STA");
    private $defaultkebun = array("SGH","SPA","SGO", "SBT","LDA", "TPU","TME", "STA", "SIN", "TER");

    public function login()
    {

        $tanggal = date('Y-m-d',strtotime('today'));
        $lastday = date('Y-m-d',strtotime('yesterday'));
        //$sp = SortasiPlasma::where('tanggal', '2022-10-23')->get();
        //dd($sp);
        $pabrik = Pabrik::all();
        $pabrik->load(['sortasiPlasma'=>function($s) use ($tanggal) {
            $s->orderBy('grade','asc')->where('tanggal', $tanggal);
        }]);

        $trip_new = SortasiPlasma::where('status', '2')->where('tanggal', $tanggal)->take(10)->orderBy('masuk', 'asc')->get();
        $nettoToday = SortasiPlasma::whereBetween('status', ['1', '2'])->where('tanggal', $tanggal)->sum('netto');
        $nettoLastDay = SortasiPlasma::whereBetween('status', ['1', '2'])->where('tanggal', $lastday)->sum('netto');
        $tripToday = SortasiPlasma::where('tanggal', $tanggal)->whereBetween('status', ['1', '2'])->count();
        $tripUpper5 = SortasiPlasma::where('tanggal', $tanggal)->where('potongan','>=','5')->count();
        $tripCancel = SortasiPlasma::where('tanggal', $tanggal)->where('status', '5')->count();

        //p adalah representasi pabrik
        $pabrik->transform(function($p) use ($tanggal){
            $p->grade_group = $p->sortasiPlasma->groupBy('grade');
            $p->grade_group->transform(function($g, $nama){
                if($nama ==""){
                    $nama ="Proses Grading";
                }
                return [
                    'grade_name'=>$nama,
                    'count'=>$g->count(),
                    'sum_netto'=>$g->sum('netto'),
                    'sum_brutto'=>$g->sum('bruto')
                ];
            });
            $p->grade_group = array_values($p->grade_group->toArray());
            return $p;
        });
        //dd($pabrik);

        $geoJSON = [];
        $geoJSON['type']='FeatureCollection';
        foreach($pabrik as $p){
            $data = [
                'type' => 'Feature',
                'properties'=> [
                    'nama'=>$p->nama,
                    'unit'=>$p->unit,
                    'totalBruto'=>collect($p->grade_group)->sum('sum_brutto'),
                    'totalNetto'=>collect($p->grade_group)->sum('sum_netto'),
                    'totalTrip'=>collect($p->grade_group)->sum('count'),
                    'grade'=> $p->grade_group,//->toArray(),
                ]
                ,
                'geometry'=>[
                    'type'=>'Point',
                    'coordinates'=>[$p->lat,$p->long]
                ],
            ];

            $geoJSON['nettoToday']=$nettoToday;
            $geoJSON['nettoLastDay']=$nettoLastDay;
            $geoJSON['triptoday']=$tripToday;
            $geoJSON['tripupper5']=$tripUpper5;
            $geoJSON['tripcancel']=$tripCancel;
            $geoJSON['features'][]=$data;
            $geoJSON['tripnew']=$trip_new;


            //untuk filter
            $geoJSON['filterPlasma']=$this->defaultplasma;
            $geoJSON['filterkebun']=$this->defaultkebun;
        }
        return response()->json($geoJSON);
    }
    public function home()
    {
        $defaultbulan = array(
            '01'=>"Januari",
            '02'=>"Februari",
            '03'=>"Maret",
            '04'=>"April",
            '05'=>"Mei",
            '06'=>"Juni",
            '07'=>"Juli",
            '08'=>"Agustus",
            '09'=>"September",
            '10'=>"Oktober",
            '11'=>"November",
            '12'=>"Desember"
        );

        $tonaseThisDay = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->Where('tanggal', '=',date('Y-m-d'))
            ->sum('netto');

        $tonaseThisMonth = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->sum('netto');

        $tonaseTillThisMonth = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '<=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->sum('netto');

        $tripThisMonth = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->count();

        $tripThisDay = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->Where('tanggal', '=',date('Y-m-d'))
            ->count();

        $tripTillThisMonth = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '<=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->count();

        $tripPotonganThisDay = SortasiPlasma::where('status','>=', '5')
            ->Where('tanggal', '=',date('Y-m-d'))
            ->count();

        $tripPotonganThisMonth = SortasiPlasma::where('status','>=', '5')
            ->WhereMonth('tanggal', '=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->count();

        $tripPotonganTillThisMonth = SortasiPlasma::where('status','>=', '5')
            ->WhereMonth('tanggal', '<=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->count();

        $tonasePerMonth = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '<=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->selectRaw("Month(tanggal) as bulan")
            ->selectRaw("SUM(netto)/1000 as total_netto")
            ->selectRaw("COUNT(netto) as total_trip")
            ->groupByRaw('Month(tanggal)')
            ->get();

        $topTrip = SortasiPlasma::whereBetween('status', ['1', '2'])
            ->WhereMonth('tanggal', '=',date('m'))
            ->whereYear('tanggal', '=',date('Y'))
            ->selectRaw("kode_kebun")
            ->selectRaw("pemasok")
            ->selectRaw("COUNT(*) as total_trip")
            ->groupByRaw('pemasok')
            ->groupByRaw('kode_kebun')
            ->orderBy('total_trip', 'DESC')
            ->take(5)
            ->get();

        $kode_kebun = SortasiPlasma::selectRaw("kode_kebun")
            ->groupByRaw("kode_kebun")->get();
        $dataa = array();

        $tanggal = date('Y-m-d');
//        echo $tanggal;

        foreach ($kode_kebun as $kbn){
            $dataGrade = SortasiPlasma::whereBetween('status', ['1', '2'])
                ->where('kode_kebun', $kbn['kode_kebun'])
                ->where('tanggal', '=', date('Y-m-d'))
                ->selectRaw('grade')
                ->selectRaw('count(*) as total_trip')
                ->selectRaw('sum(netto)/1000 as total_netto')
                ->groupByRaw('grade')
                ->get();
            $newData = array(
                'nama_kebun'=>$kbn['kode_kebun'],
                'grade'=>$dataGrade
            );
            $dataa[] = $newData;
        }

        $geoJSON = [];
        $geoJSON['tonaseThisDay'] = $tonaseThisDay/1000;
        $geoJSON['tonaseThisMonth'] = $tonaseThisMonth/1000;
        $geoJSON['tonaseTillThisMonth'] = $tonaseTillThisMonth/1000;
        $geoJSON['tripThisDay'] = $tripThisDay;
        $geoJSON['tripThisMonth'] = $tripThisMonth;
        $geoJSON['tripTillThisMonth'] = $tripTillThisMonth;
        $geoJSON['tripPotonganThisDay'] = $tripPotonganThisDay;
        $geoJSON['tripPotonganThisMonth'] = $tripPotonganThisMonth;
        $geoJSON['tripPotonganTillThisMonth'] = $tripPotonganTillThisMonth;
        $geoJSON['tonasePerMonth'] = $tonasePerMonth;
        $geoJSON['topTrip'] = $topTrip;
        $geoJSON['gradeToday'] = $dataa;

        return json_encode($geoJSON);
    }
}
