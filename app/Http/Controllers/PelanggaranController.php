<?php

namespace App\Http\Controllers;

use App\Pemasok;
use Illuminate\Support\Facades\DB;

class PelanggaranController extends Controller
{
    //
    public function index()
    {
        $today = date('Y-m-d');
        $PemasokHarian = Pemasok::join('sortasi_plasma', 'pemasok.nama', '=', 'sortasi_plasma.pemasok')
            ->select('pemasok.nama',  DB::raw('MAX(sortasi_plasma.on_create) as tanggal_pelanggaran'), DB::raw('SUM(sortasi_plasma.netto) as total_netto'), 'pemasok.norma_harian')
            ->groupBy('pemasok.nama', 'pemasok.norma_harian')
            ->havingRaw('SUM(sortasi_plasma.netto) > pemasok.norma_harian')
            ->havingRaw("DATE(tanggal_pelanggaran) = ?", [$today])
            ->get();
        return response()->json($PemasokHarian);
    }
}
