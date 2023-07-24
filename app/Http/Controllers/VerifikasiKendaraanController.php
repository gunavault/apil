<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiKendaraanController extends Controller
{
    public function checkVerifikasi(Request $request)
    {
        // Validate input data (optional)
        $request->validate([
            'nopol' => 'required|string|max:25',
            'pemasok' => 'required|string|max:100',
        ]);

        $nopol = $request->input('nopol');
        $pemasok = $request->input('pemasok');

        // Query the database to check if the data exists
        $exists = DB::table('verifikasikendaraan')
            ->where('nopol', $nopol)
            ->where('pemasok', $pemasok)
            ->exists();

        // If data exists, return the appropriate response
        if ($exists) {
            return response()->json([
                "status" => "succes",
                'message' => 'Data kendaraan ada dengan nomor polisi '.$nopol.' dan dari '.$pemasok.''
            ]);
        } else {    
            // If data doesn't exist, insert into the 'notifikasiwa' table
            DB::table('notifikasiwa')->insert([
                'nomor_hp_pemasok' => "0895167370731",
                'pemasok' => $pemasok,
                'file' => 'www.google.com',
                'pesan' => "Tolong daftarkan kendaraan dengan nopol #" . $nopol . "# dan pemasok #" . $pemasok . "#",
                'status' => null,
            ]);

            return response()->json([
                "status" => "error",
                'message' => 'Data kendaraan tidak ada. Notifikasi telah ditambahkan.'
            ]);
        }
    }
}
