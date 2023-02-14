@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Men Power Plan PTPN 5</h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Kekuatan Tenaga Kerja</h3>
                <br>
                <br>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" method="GET" action="{{url('/home')}}">
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>Kebun : </th>
{{--                                            //step 1 maenambahkan id=bkn--}}
                                            <td><select class="custom-select" id="kbn" name="kbn">
                                                    @foreach($list_kbn as $list_kbn)
                                                        @if($list_kbn['p_subarea']==$kbn)
                                                        <option value="{{$list_kbn['p_subarea']}}" selected>{{$list_kbn['personnel_subarea']}}</option>
                                                        @else
                                                        <option value={{$list_kbn['p_subarea']}}>{{$list_kbn['personnel_subarea']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Bulan : </th>
{{--                                            //step 1 maenambahkan id=bkn--}}
                                            <td><select class="custom-select" id="bln" name="bln">
                                                    @foreach($bulan as $key=>$value)
                                                        @if($key == $bln)
                                                            <option value="{{$key}}" selected>{{$value}}</option>
                                                        @else
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <th>Tahun : </th>
{{--                                            //step 1 maenambahkan id=bkn--}}
                                            <td><select class="custom-select" id="thn" name="thn">
                                                    @for($tahunlist = date('Y')-1;$tahunlist<=date('Y')+1; $tahunlist++)

                                                        @if($tahunlist == $thn)
                                                            <option value="{{$tahunlist}}" selected>{{$tahunlist}}</option>
                                                        @else
                                                            <option value="{{$tahunlist}}">{{$tahunlist}}</option>
                                                        @endif
                                                    @endfor
                                                </select></td>
                                        </tr>
                                        <tr>

                                            <td><button onclick="myFunction()" class="btn btn-info">Lihat</button></td>
                                               <p id="demo"></p>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="output" style="margin: 30px;"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->

            </form>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')

    <!-- external libs from cdnjs -->
    <script src="https://cdn.plot.ly/plotly-basic-latest.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pivot.css')}}">
    <script type="text/javascript" src="{{asset('js/pivot.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plotly_renderers.js')}}"></script>
    <style>
        body {font-family: Verdana;}
    </style>

    <!-- optional: mobile support with jqueryui-touch-punch -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <!-- for examples only! script to show code to user -->
{{--    <script type="text/javascript" src="{{asset('js/show_code.js')}}"></script>--}}

    <script type="text/javascript">
        // This example adds Plotly chart renderers.

        $(function(){
            var derivers = $.pivotUtilities.derivers;
            var renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.plotly_renderers);

            var kbn = $("#kbn").val();
            var bln = $("#bln").val();
            var thn = $("#thn").val();
            var xy = thn+''+bln;
            console.log(kbn,xy);
            //step 2 kan ? dipanggil id bkn di atas tadi
            {{--$.getJSON("{{url('ajaxData')}}?kbn="+kbn+"&bulan=", function(mps) {--}}
                // step 3 tambahkan link dibelakang nya, kayak lu nambahkan bulan
            $.getJSON("{{url('ajaxData')}}?kbn="+kbn+"&bln="+bln+"&thn="+thn, function(mps) {
            {{--$.getJSON({!! json_encode($tenagakerja) !!}, function(mps) {--}}
                $("#output").pivotUI(mps, {
                    renderers: renderers,
                    cols: ["empgroup_desc"], rows: ["division_name","job_name"],
                    rendererName: "Table",
                    rowOrder: "value_a_to_z", colOrder: "value_z_to_a",
                });
            });
        });
    </script>
@stop

