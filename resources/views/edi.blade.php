@extends('layout')
@section('title','Container Register')
@section('content')
@section('css')
     <!-- DataTables -->
     <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
     <!-- Responsive datatable examples -->
     <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
@endsection
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
                            <li class="breadcrumb-item"><a href="javascript:;">Container Register</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Container Register</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        {{-- @livewire('daily-report.container-register') --}}
<div class="card text-left">
  <div class="card-body">
    <form action="{{route('edi_fetch')}}" method="post">
        @csrf
    <div class="form-group row">
        <div class="col-2">
            <label for="datepicker">Select Start Date</label>
            <input class="form-control" type="date" value="{{$start_date}}" required name="start_date" id="start_date">
        </div>
        <div class="col-2">
            <label for="datepicker">Select End Date</label>
            <input class="form-control" type="date" value="{{$end_date}}" required name="end_date" id="end_date">
        </div>
        <div class="col-2">
            <label for="shipping_line">Shipping Line</label>
            <div class="form-group">
              <select class="form-control" required name="shipping" id="shipping">
                <option value="">Select Shipping</option>
                @foreach ($shipping as $item)
                    <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-2">
            <label for="check_table"> Select Movement </label>
            <div class="form-group">
              <select class="form-control" name="check_table" id="check_table">
                <option value="in_containers" selected>In Records</option>
                <option value="out_containers" >Out Records</option>
              </select>
            </div>
        </div>
        <div class="col-2">
            <label for=""></label><br>
            <input type="submit" class="btn btn-info" value="Search">
        </div>
    </div>
</form>
  </div>
</div>
<div class="card text-left">
  <div class="card-body">
      
    <button id= "edi_report" class="btn btn-info">EDI Report</button>
    <table id="datatable-buttons_2" class="table table-responsive table-striped table-bordered nowrap">
        <thead>
            @if (!empty($data))
            @if ($activity == 'IN CONTAINER')
            <tr>
                <th>CONTAINER</th>
                <th>ACTIVITY</th>
                <th>ACT DATE</th>
                <th>PORT</th>
                <th>STATUS</th>                
                <th>LOCATION</th>                
                <th>REMARKS</th>
                <th>VOYAGE NAME</th>
                <th>TRANSPORTER</th>
                <th>REFNO</th>
            </tr>
            @else
            <tr>
                <th>CONTAINER</th>
                <th>ACTIVITY</th>
                <th>ACT DATE</th>
                <th>PORT</th>
                <th>STATUS</th>                
                <th>LOCATION</th>                
                <th>REMARKS</th>
                <th>PORT LOAD</th>
                <th>ORIGINAL PORT</th>
                <th>FINAL DEST</th>
                <th>VOYAGE NAME</th>
                <th>TRANSPORTER</th>
                <th>REFNO</th>
            </tr>
            @endif
            @else
            <tr>
                <th>CONTAINER</th>
                <th>ACTIVITY</th>
                <th>ACT DATE</th>
                <th>PORT</th>
                <th>STATUS</th>                
                <th>LOCATION</th>                
                <th>REMARKS</th>
                <th>PORT LOAD</th>
                <th>ORIGINAL PORT</th>
                <th>FINAL DEST</th>
                <th>VOYAGE NAME</th>
                <th>TRANSPORTER</th>
                <th>REFNO</th>
            </tr>
            @endif
        </thead>
        <tbody>
           @if (!empty($data))
                @if ($activity == 'IN CONTAINER')
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->container_no}}</td>
                            <td>{{$activity}}</td>
                            <td>{{$item->in_date}}</td>
                            <td>{{$item->port_from}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->depot_code}}</td>
                            <td>{{$item->depot}}</td>
                            <td>{{$item->booking_remark}}</td>
                            <td>{{$item->vessel}}</td>
                            <td>{{$item->transpoter}}</td>
                            <td>{{$item->import_do}}</td>

                        </tr>
                    @endforeach
                @else
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->container_no}}</td>
                            <td>{{$activity}}</td>
                            <td>{{$item->out_date}}</td>
                            <td>{{$item->out_depot}}</td>
                            <td>{{$item->out_status}}</td>
                            <td>{{$item->depot_code}}</td>
                            <td>{{$item->remak_note}}</td>
                            <td>{{$item->original_port}}</td>
                            <td>{{$item->original_port}}</td>
                            <td>{{$item->final_dest}}</td>
                            <td>{{$item->out_vessel}}</td>
                            <td>{{$item->out_transpoter}}</td>
                            <td>{{$item->export_do}}</td>

                        </tr>
                    @endforeach
                @endif
               
           @endif
        </tbody>
    </table>
         
    {{-- @if ($this->data !== null)
    <div class="row">{{$this->data->links('')}}</div>
    @endif --}}
    
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
    <script>
        $("#edi_report").click(function() {
            var postData = {};
            postData['content'] = {};
            postData['start_date'] = $("#start_date").val();
            postData['end_date'] = $("#start_date").val();
            postData['shipping'] = $("#shipping").val();
            postData['check_table'] = $("#check_table").val();
            // postData['content'] = table2.rows().data();
            // data input for testing
            postData['content'][0] = {};
            postData['content'][0]['container'] = 1;
            postData['content'][0]['status'] = 12;
            postData['content'][0]['transporter'] = 13;
            postData['content'][0]['location'] = 21;
            postData['content'][0]['port'] = 41;
            postData['content'][1] = {};
            postData['content'][1]['container'] = 1;
            postData['content'][1]['status'] = 12;
            postData['content'][1]['transporter'] = 13;
            postData['content'][1]['location'] = 21;
            postData['content'][1]['port'] = 41;
            // end test data 
            $.post("/edi_report",{postData},function(res){
                download(res);
            });
            function download(filename) {
            var element = document.createElement('a');
            element.setAttribute('href','data:text/plain;charset=utf-8, '+ encodeURIComponent(filename));
            element.setAttribute('download', "edi_report.edi");
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
            }
        });
    </script>
@endsection