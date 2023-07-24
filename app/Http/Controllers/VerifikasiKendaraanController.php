<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import the QR Code facade

use Matrix\Decomposition\QR;

class VerifikasiKendaraanController extends Controller
{
    public function checkVerifikasi(Request $request)
{
    $nopol = $request->query('nopol');
    $pemasok = $request->query('pemasok');

    if (!$nopol) {
        return response()->json(['message' => 'Parameter "nopol" is missing.'], 400);
    }

    if (!$pemasok) {
        return response()->json(['message' => 'Parameter "pemasok" is missing.'], 400);
    }

    // Query the database to check if the data exists
    $exists = DB::table('verifikasikendaraan')
        ->where('nopol', $nopol)
        ->where('pemasok', $pemasok)
        ->exists();

    // If data exists, return the appropriate response
    if ($exists) {
        return response()->json([
            'status' => 'success',
            'message' => 'Data kendaraan ada']);
    } else {
        // If data doesn't exist, insert into the 'notifikasiwa' table
        DB::table('notifikasiwa')->insert([
            'nomor_hp_pemasok' =>"089516370731", // Assuming you still want to pass this parameter
            'pemasok' => $pemasok,
            'file' => 'www.google.com',
            'pesan' => "Tolong daftarkan kendaraan dengan nopol #" . $nopol . "# dan pemasok #" . $pemasok . "#",
            'status' => null,
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Data kendaraan tidak ada. Notifikasi telah ditambahkan.'
        
        ]);
    }
}

public function viewverifikasi(Request $request) {
    $nopol = $request->query('nopol');
    $pemasok = $request->query('pemasok');

    $namapemasokdata = DB::table('pemasok')->selectRaw('nama')->get();
    if (!$nopol) {
        return view('welcome', compact('namapemasokdata'));
    }

    if (!$pemasok) {
        return view('welcome', compact('namapemasokdata'));
    }

    // Query the database to check if the data exists
    $exists = DB::table('verifikasikendaraan')
        ->where('nopol', $nopol)
        ->where('pemasok', $pemasok)
        ->exists();

    // If data exists, return the appropriate response
    if ($exists) {
        // Assuming you want to display this message in the view as well
        $message = 'Data kendaraan dengan nomor polisi ' . $nopol . ' dan pemasok ' . $pemasok . ' Terverifikasi.';
        return view('succes', compact('namapemasokdata','exists', 'message'))
            ->with('status', 'success');
    } else {
        // Assuming you want to display this message in the view as well
        $message = 'Data kendaraan tidak ada. Notifikasi telah ditambahkan.';
        return view('succes', compact('namapemasokdata','exists', 'message'))
            ->with('status', 'error')
            ->with('notifikasi', 'Data kendaraan tidak ada. Notifikasi telah ditambahkan.');
    }
}

public function createQRLink(Request $request)
    {
        $nopol = $request->input('nopol');
        $pemasok = $request->input('pemasok');

        if (!$nopol || !$pemasok) {
            return response()->json(['message' => 'Nilai "Nomor Polisi" dan "pemasok" diperlukan.'], 400);
        }

        // Create the QR code link
        $qrLink = "http://localhost:8000/viewverifikasi?nopol={$nopol}&pemasok={$pemasok}";

        $encodedQrLink = urlencode($qrLink);

         // Save the QR code image to a public directory (e.g., 'storage/qr_codes')
        $qrImagePath = public_path('temp/' . $nopol . '_' . $pemasok . '.png');
        QrCode::size(300)->generate($qrLink, $qrImagePath);

        // Save the QR code link to the database (assuming you have a valid database connection)
        $id = DB::table('verifikasikendaraan')->insertGetId([
            'nopol' => $nopol,
            'nomor_hp_pemasok' => $request->input('nomor_hp_pemasok'),
            'pemasok' => $pemasok,
            'jeniskendaraan' => $request->input('jeniskendaraan'),
            'qr_link' => $encodedQrLink,


        ]);

        

        // Optionally, you can redirect to a success page or return a response with the generated QR code link
        return View::make('qr_code_generated', ['qr_link' => $encodedQrLink,'link'=> $qrLink, 'qr_image_path' => $qrImagePath]);
    }

}
