<?php

namespace App\Http\Controllers;

use App\Pemasok;
use App\SortasiPlasma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {        
        {
            $date = $request->input('date') ?? '2023-07-19';
            $kebun = $request->input('kebun') ?? '';
            if ($kebun != ''){
                $PemasokHarian = Pemasok::join('sortasi_plasma', 'pemasok.nama', '=', 'sortasi_plasma.pemasok')
                    ->select('pemasok.nama',  DB::raw('MAX(sortasi_plasma.tanggal) as tanggal'), DB::raw('SUM(sortasi_plasma.netto) as total_netto'), 'pemasok.norma_harian',
                        DB::raw('(SUM(sortasi_plasma.netto) > pemasok.norma_harian) as melebihi_norma'))
                    ->groupBy('pemasok.nama', 'pemasok.norma_harian')
                    ->havingRaw('SUM(sortasi_plasma.netto) > pemasok.norma_harian')
                    ->havingRaw("DATE(MAX(sortasi_plasma.tanggal)) = ?", [$date])
                    ->where('pemasok.unit', $kebun)
                    ->get();
            }
            else{
                $PemasokHarian = Pemasok::join('sortasi_plasma', 'pemasok.nama', '=', 'sortasi_plasma.pemasok')
                    ->select('pemasok.nama',  DB::raw('MAX(sortasi_plasma.tanggal) as tanggal'), DB::raw('SUM(sortasi_plasma.netto) as total_netto'), 'pemasok.norma_harian',
                        DB::raw('(SUM(sortasi_plasma.netto) > pemasok.norma_harian) as melebihi_norma'))
                    ->groupBy('pemasok.nama', 'pemasok.norma_harian')
                    ->havingRaw('SUM(sortasi_plasma.netto) > pemasok.norma_harian')
                    ->havingRaw("DATE(MAX(sortasi_plasma.tanggal)) = ?", [$date])
                    ->get();
            }

        // Add status column based on 'melebihi_norma' value
        foreach ($PemasokHarian as $pemasok) {
            $pemasok->status = $pemasok->melebihi_norma ? "Melebihi norma" : "Normal";
            unset($pemasok->melebihi_norma);
        }

        return response()->json($PemasokHarian);
    }
}
}
