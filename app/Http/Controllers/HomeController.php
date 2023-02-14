<?php

namespace App\Http\Controllers;

use App\StaticValue;
use App\TenagaKerjaModel;
use App\UnitKebunModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $defaultKbn = "EK20";

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function ajax(Request $request){
        //step 4 nya gmana disini
//        dump($request);
//        $tenagakerja = TenagaKerjaModel::where('perssub_area',$request->kbn)
        $periods = $request->thn.''.$request->bln;
        $tenagakerja = TenagaKerjaModel::where('perssub_area',$request->input('kbn'))
            ->where('for_period_for_payroll',$periods)
             // dah itu aja
            ->select('perssub_area', 'perssub_area_desc', 'job','job_name','gender', 'name', 'division_name', 'empgroup', 'empgroup_desc', 'golongan')
            ->get();
//        echo json_encode($period);
        return response()->json($tenagakerja);
    }
    public function index()
    {
        $kbn = request('kbn')?: $this->defaultKbn;
        $bln = request('bln')?: date('n');
        $thn = request('thn') ?: date('Y');
        $bulan = StaticValue::bulan();
        $list_kbn = UnitKebunModel::all();
//        dump($tahun.''.$period);
        return view('home', compact('list_kbn','bulan','kbn','bln','thn'));
    }
}
