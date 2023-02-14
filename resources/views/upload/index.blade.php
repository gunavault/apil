@extends('adminlte::page')

@section('title', 'MPP PTPN V')

@section('content_header')
    <h1>Daftar Upload</h1>
@stop

@section('content')
    <div class="container-fluid">

      
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            @if(session('message'))
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible">
                        <h5><i class="icon fas fa-check"></i> Upload Sukses!</h5>
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <!-- general form elements -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Upload File XLSX</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control" id="tahun" form="mpp_form" name="tahun">
                                @for($year = now()->year; $year>=2021; $year--)
                                    <option value="{{ $year }}" {{ ($year == now()->year)?'selected':'' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control" id="bulan" form="mpp_form" name="bulan">
                                @for($bulan = 1; $bulan<=12; $bulan++)
                                    <option value="{{ $bulan }}" {{ ($bulan == now()->month)?'selected':'' }}>{{ bulan_indonesia($bulan) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Upload File</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="{{ url('format_upload/format_upload_mpp.csv') }}" class="btn btn-warning" ><i class="fa fa-download"></i></a>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="mpp_file" class="custom-file-input" id="mpp_file" data-prefix="File CSV" form="mpp_form" accept=".csv">
                                    <label class="custom-file-label" for="mpp_file">File CSV</label>
                                </div>
                                <div class="input-group-append">
                                    <input type="submit" class="btn btn-primary" value="Simpan" form="mpp_form">
                                </div>
                            </div>
                            

                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>



                <form enctype="multipart/form-data" method="post" action="{{ url('upload') }}" id="mpp_form">
                    @csrf
                </form>


            </div>
            <!-- /.card -->



        </div>
        <!--/.col (left) -->
    </div>
    <!-- /.row -->

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">&nbsp;</h3>

              <div class="card-tools">
                <a href="upload/create" type="button" class="btn btn-tool" title="Contacts" >
                    <i class="fas fa-plus"></i>
                </a>
                {{-- <ul class="pagination pagination-sm float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>Model</th>
                    <th>Jumlah Data</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($uploads as $u)
                  <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->filename }}</td>
                    <td>{{ $u->model }}</td>
                    <td>{{ $u->n_baris_excel }}</td>
                    <td></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul> --}}
                {{ $uploads->links() }}
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('css')
    <!--<link rel="stylesheet" href="{{ url("/css/admin_custom.css") }}">-->
@stop

@section('js')
    <script> 
    $(document).ready(function(){
      //$('.pagination').addClass("pagination-sm m-0 float-right");

      $('input[type="file"]').change(function(e){
                var fileName = $(this).data('prefix')+': '+ e.target.files[0].name;
                $(this).siblings('.custom-file-label').html(fileName);
            });
      });
    </script>
@stop