<?php

namespace App\Imports;

use App\TenagaKerjaModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TenagaKerjaImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithEvents
{
    use RemembersRowNumber;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        //dd($row);

        $this->row_number = $this->getRowNumber();

        //jika row_number nya kelipatan x, maka kirim pusher
        // if($this->row_number%10000 == 0 ){
        //     event(new UpdateProcessedUploadData($this->upload_id, $this->row_number, 'on_progress'));
        // }

        return new TenagaKerjaModel(
            $row
        );
    }
    

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 10000;
    }

    public function registerEvents(): array
    {
        $upload_id = $this->upload_id;

        return [
            /* 
            BeforeImport::class => function(BeforeImport $event) use ($upload_id) {

                $this->aktifitas = Aktifitas::select('aktifitas', 'grup_aktifitas')->where('aktif',1)->get();
                $this->grup_aktifitas = $this->aktifitas->keyBy('aktifitas');
                $this->grup_aktifitas->transform(function($akt){
                    return $akt->grup_aktifitas;
                });
                //$cost_center_ee = $this->grup_aktifitas

                $totalRows = $event->getReader()->getTotalRows();
                $n_baris_excel = collect($totalRows)->first();
                Upload::where('id', $upload_id)->update(['n_baris_excel'=>$n_baris_excel]);
            },

            AfterImport::class => function(AfterImport $event) use ($upload_id) {

                Upload::where('id', $upload_id)->update(['status'=>'finished']);
                
                AfterImportBiayaAll::dispatch($upload_id);
            },

            ImportFailed::class => function(ImportFailed $event) use ($upload_id)  {

                $jumlah_data = ByAll::where('upload_id', $upload_id)->count();
                event(new UpdateProcessedUploadData($upload_id, $jumlah_data, 'failed'));
                Upload::where('id', $upload_id)->update(['status'=>'failed']);
            },
             */

        ];
    }
}
