<html>
<style>
    .legend span {
        border: 1px solid #ccc;
        float: left;
        width: 12px;
        height: 12px;
        margin: 3px;
    }

    .legend {
        list-style: none;
    }

    .legend li {
        float: left;
        margin-right: 10px;
    }

    table td {
        border: thin black;
    }
</style>
<table>
    <thead>
    <tr style="border: 1px black">
        <th style="border: medium black; background: #00a87d" rowspan="2">Kode Kebun</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Kode Plasma</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Jenis</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Tanggal</th>
        <th style="border: medium black; background: #00a87d" colspan="3">Data Lama Bongkar</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Pemasok</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">No Polisi</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Supir</th>
        <th style="border: medium black; background: #00a87d" colspan="2">Tonase</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Jumlah TBS diterima</th>
        <th style="border: medium black; background: #00a87d" colspan="3">TBS yang dipulangkan</th>
        <th style="border: medium black; background: #00a87d" colspan="4">Data Grading</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Potongan</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Catatan</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Status</th>
        <th style="border: medium black; background: #00a87d" rowspan="2">Dibuat</th>
    </tr>
    <tr>
        <th style="border: medium black; background: #00a87d">Jam Masuk</th>
        <th style="border: medium black; background: #00a87d">Jam Keluar</th>
        <th style="border: medium black; background: #00a87d">Durasi</th>
        <th style="border: medium black; background: #00a87d">Bruto</th>
        <th style="border: medium black; background: #00a87d">Netto</th>
        <th style="border: medium black; background: #00a87d">TBS Mentah</th>
        <th style="border: medium black; background: #00a87d">TBS Tankos</th>
        <th style="border: medium black; background: #00a87d">TBS Kecil</th>
        <th style="border: medium black; background: #00a87d">Jumlah TBS Sample</th>
        <th style="border: medium black; background: #00a87d">Tenera (%)</th>
        <th style="border: medium black; background: #00a87d">Dura (%)</th>
        <th style="border: medium black; background: #00a87d">Grade</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $data)
        @if($data->status != 1)
        <tr>
            <td style="border: medium black">{{ $data->kode_kebun }}</td>
            <td style="border: medium black">{{ $data->kode_plasma }}</td>
            <td style="border: medium black">{{ $data->jenis }}</td>
            <td style="border: medium black">{{ $data->tanggal }}</td>
            <td style="border: medium black">{{ $data->masuk }}</td>
            <td style="border: medium black">{{ $data->keluar }}</td>
            <td style="border: medium black">{{ $data->durasi }}</td>
{{--            <td>{{ $data->jenis_truck }}</td>--}}
            <td style="border: medium black">{{ $data->pemasok }}</td>
            <td style="border: medium black">{{ $data->nopol }}</td>
            <td style="border: medium black">{{ $data->supir }}</td>
            <td style="border: medium black">{{ $data->bruto }}</td>
            <td style="border: medium black">{{ $data->netto }}</td>
            <td style="border: medium black">{{ $data->jumlah_tbs_diterima }}</td>
            <td style="border: medium black">{{ $data->tbs_mentah }}</td>
            <td style="border: medium black">{{ $data->tbs_tankos }}</td>
            <td style="border: medium black">{{ $data->tbs_kecil }}</td>
            <td style="border: medium black">{{ $data->jumlah_tbs_sample }}</td>
            <td style="border: medium black">{{ $data->tenera }}</td>
            <td style="border: medium black">{{ $data->dura }}</td>
            <td style="border: medium black">{{ $data->grade }}</td>
            @if($data->potongan > 4)
                <td style="border: medium black;background-color: red; color: white">{{ $data->potongan }}</td>
            @else
                <td style="border: medium black">{{ $data->potongan }}</td>
            @endif
            <td style="border: medium black">{{ $data->catatan }}</td>
            @if($data->status == 2)
            <td style="border: medium black">{{ $data->status }}</td>
            @elseif($data->status == 5)
                <td style="border: medium black; color: red">Pengajuan Pembatalan</td>
            @elseif($data->status == 7)
                <td style="border: medium black; color: red">Pembatalan Telah Diperiksa</td>
            @endif
                <td style="border: medium black">{{ $data->on_create }}</td>

        </tr>
        @else
            <tr>
                <td style="border: medium black; background: #5a6268">{{ $data->kode_kebun }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->kode_plasma }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->jenis }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->tanggal }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->masuk }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->keluar }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->durasi }}</td>
                {{--            <td>{{ $data->jenis_truck }}</td>--}}
                <td style="border: medium black; background: #5a6268">{{ $data->pemasok }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->nopol }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->supir }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->bruto }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->netto }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->jumlah_tbs_diterima }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->tbs_mentah }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->tbs_tankos }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->tbs_kecil }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->jumlah_tbs_sample }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->tenera }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->dura }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->grade }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->potongan }}</td>
                <td style="border: medium black; background: #5a6268">{{ $data->catatan }}</td>
                <td style="border: medium black; background: #5a6268"> Data Belum Diisi</td>
                <td style="border: medium black; background: #5a6268">{{ $data->on_create }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>


<table class="toolbar">
    <tr class="legend float-left">
        <td style="background-color: #ffb3b3; color: #ffb3b3"></td>
        <td>Laporan Bongkar Lebih Cepat</td>
    </tr>
    <tr>
        <td style="background-color: #fcbe72; color: #fcbe72"></td>
        <td> Potongan > 5 Persen</td>
    </tr>
    <tr>
        <td style="background-color: #bfc7c7; color: #bfc7c7"></td>
        <td>Jenis Kendaraan Belum Diisi / Data Grade Belum Diisi</td>
    </tr>
</table>

</html>
