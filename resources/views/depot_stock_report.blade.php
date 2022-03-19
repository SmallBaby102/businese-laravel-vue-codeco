@extends('layout')
@section('title','Depot Stock Report')
@section('css')
     <!-- DataTables -->
     <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <!-- Responsive datatable examples -->
     <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')

@section('header')
    @livewire('header')
@endsection
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">Depot Stock Report</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Depot Stock Report</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        {{-- @livewire('daily-report.depot-stock-report') --}}
     
    <div class="card text-left">
      <div class="card-body">
          <form action="{{route('depot_stock_report_fetch')}}" method="post">
            @csrf
        <div class="form-group row">
            <div class="col-2">
                <label for="datepicker">Select Start Date</label>
                <input class="form-control" required type="date" value="{{$select_date}}" name="select_date" id="datepicker">
            </div>
            <div class="col-2">
                <button class="btn btn-info mt-4">Search</button>
            </div>
            <div class="col-2">
                <input type="number" class="form-control mt-4" name="" value="{{$company->total_tues}}" id="store_total_tues">
                <label>Remaining Tues: <span id="remaining_tues"></span></label>
            </div>
        </div>
    </form>
      </div>
    </div> 
    <div class="card text-left">
      <div class="card-body">
        <table id="datatable-buttons" class="table table-striped table-responsive table-bordered nowrap w-100">
            <thead>
                <tr>
                    <th>&nbsp; Rows/Cells &nbsp;</th>
                    @foreach ($container_type as $item)
                    <th>&nbsp;&nbsp;{{$item->size.$item->type}}&nbsp;&nbsp;</th>
                    @endforeach
                    <th>Total</th>
                    <th>Total Tues</th>   
                </tr>
            </thead>
            <tbody>
                @php
                    $total_tues = 0;
                @endphp
                @foreach ($shipping as $item)
                    <tr>
                    <th>{{$item->client_name}}</th>
                    @if (!empty( $data ))
                        @if (in_array($item->client_name,$client))
                            @php
                                $total = 0;
                                $size_20 = 0;
                                $size_40 = 0;
                                for($i = 0; $i < count($size); $i++){
                                    if (in_array($size[$i],$new_size)) {
                                        if (array_key_exists($type[$i],$data[$item->client_name][$size[$i]])) {
                                            echo "<th>".$data[$item->client_name][$size[$i]][$type[$i]]."</th>";
                                            $total += $data[$item->client_name][$size[$i]][$type[$i]];
                                            if ($size[$i] == 40) {
                                                $size_40 += $data[$item->client_name][$size[$i]][$type[$i]];
                                            }else{
                                                $size_20 += $data[$item->client_name][$size[$i]][$type[$i]];
                                            }
                                        }else{
                                            echo "<th>0</th>";
                                        }
                                    }else{
                                        echo "<th>0</th>";
                                    }
                                }
                                $tues = $size_40 * 2;
                                echo "<th>".$total."</th>";
                                echo "<th>".$size_20 + $tues."</th>";
                                $total_tues = $total_tues + $size_20 + $tues;
                            @endphp
                        @endif
                    @endif
                </tr>
                @endforeach
                @php
                    $total_tues = $company->total_tues - $total_tues;
                @endphp
                <script>
                    document.getElementById("remaining_tues").innerHTML='{{$total_tues}}';
                </script>
            </tbody>
        </table>
        
        {{-- <div class="row">{{$data->links()}}</div> --}}
      </div>
    </div>
</div>
</div>
@endsection
@section('js')
    <!-- Required datatable js -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
@endsection