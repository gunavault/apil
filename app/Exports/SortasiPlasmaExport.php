<?php

namespace App\Exports;

use App\Harga;
use App\SortasiPlasma;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SortasiPlasmaExport implements FromView, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $str, string $end, string $kbn)
    {
        $this->start = $str;
        $this->end = $end;
        $this->kebun = $kbn;
    }

    public function view():View
    {
        return view(
            'reportdata', [
                'data' =>
                    \DB::table('sortasi_plasma AS c')
                        ->select(\DB::raw('c.kode_kebun,
            c.kode_plasma,
            c.jenis,
            c.tanggal,
            c.masuk,
            c.keluar,
            c.durasi,
            c.jenis_truck,
             (SELECT lama_bongkar FROM lama_bongkar WHERE kode_kebun=c.kode_kebun AND jenis_truck= c.jenis_truck) AS valuemenit,
             c.pemasok,
             c.nopol,
             c.supir,
             c.bruto,
             c.netto,
             c.jumlah_tbs_diterima,
             c.tbs_mentah,
             c.tbs_tankos,
             c.tbs_kecil,
             c.jumlah_tbs_sample,
             c.tenera,
             c.dura,
             c.grade,
             c.potongan,
             c.catatan,
            c.`status`,
             c.on_create'))
                        ->where('c.kode_kebun', $this->kebun)
                        ->whereBetween('c.tanggal', [$this->start,$this->end])
                        ->orderBy('c.kode_kebun')
                        ->get()
            ]
        );


////        $a = SortasiPlasma::where('tanggal', date('Y-m-d'))->get();
//            return $a;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('E2')->getFont()->setBold(true);
//        $styleArray = [
//            'borders' => [
//                'outline' => [
//                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                    'color' => ['argb' => 'FFFF0000'],
//                ],
//            ],
//        ];
//
//        $sheet->getStyle('B2:G8')->applyFromArray($styleArray);
    }
}
