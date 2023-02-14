<?php

namespace App\Http\Controllers;

use App\Imports\TenagaKerjaImport;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uploads = Upload::paginate(15);
        return view('upload.index', compact('uploads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('upload.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->mpp_file->storeAs('uploads', now()->format("Ymd_His_") . Str::snake( $request->mpp_file->getClientOriginalName()));
        //dd($path);
        
        $upload = $this->create_upload_record('TenagaKerjaModel', 'TenagaKerjaImport', $path, 0, $request->tahun, $request->bulan);

        $import = new TenagaKerjaImport();
        $import->tahun = $request->tahun;
        $import->bulan = $request->bulan;
        $import->upload_id = $upload->id;

        Excel::import($import, $path);

        return back()->with('message', $path." sedang diproses...");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        //
    }

    

    public function create_upload_record($model, $import_class, $filename, $n_baris_excel, $tahun, $bulan)
    {

        $upload = Upload::create([
            'model' => $model,
            'import_class' => $import_class,
            'filename' => $filename,
            'n_baris_excel' => $n_baris_excel,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'tahun_bulan' => sprintf("%d%02d",$tahun,$bulan)
        ]);

        //ReloadUploadCache::dispatch();

        return $upload;
    }

    
}
