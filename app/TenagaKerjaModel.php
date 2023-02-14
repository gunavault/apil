<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\masterJobMode;


class TenagaKerjaModel extends Model
{
    protected $table = 'tenagakerja';
    protected $guarded =[];

    protected function tenagakerja(){
        $result=DB::table('tenagakerja')
            ->join('master_job', 'tenagakerja.job', '=', 'master_job.no_job')
            ->select('tenagakerja.employee_group', 'tenagakerja.personnel_subarea','tenagakerja.job', 'tenagakerja.job1',
                DB::raw("count(tenagakerja.job) as total"),DB::raw("count(case  when tenagakerja.employee_group LIKE '%Tetap' then 1 else  null end) as total_tetap"),
            DB::raw("count(case  when tenagakerja.es_grp = 'CC' then 1 else  null end) as total_pkwt"),
            DB::raw("count(case  when tenagakerja.es_grp = 'CD' then 1 else  null end) as total_khl")
            )
            ->where('tenagakerja.personnel_subarea','Tamora')
            ->groupBy(['tenagakerja.personnel_subarea','tenagakerja.employee_group', 'tenagakerja.job','tenagakerja.job1'])
            ->orderBy('tenagakerja.personnel_subarea', 'asc')
            ->orderBy('master_job.sort_divisi', 'asc')
            ->orderBy('master_job.sort_by', 'asc')
            ->get();
        return $result;
    }
}
