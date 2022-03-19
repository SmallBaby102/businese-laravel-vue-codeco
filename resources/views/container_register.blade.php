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
    <form action="{{route('container_register_fetch')}}" method="post">
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
              <select class="form-control" name="shipping" id="shipping">
                <option value="all" selected>All</option>
                @foreach ($shipping as $item)
                    <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-2">
            <label for="sstatus">Shipping status</label>
            <div class="form-group">
              <select class="form-control" name="status" id="sstatus">
                <option value="all" selected>All</option>
                @foreach ($status_master as $item)
                    <option value="{{$item->status_code}}">{{$item->status_detail}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-2">
            <label for="check_table"></label>
            <div class="form-group">
              <select class="form-control" name="check_table" id="check_table">
                <option value="1" selected>In Records</option>
                <option value="2" >Out Records</option>
                {{-- <option value="3" >Combine Records</option> --}}
                <option value="4" >Availabel Date</option>
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
    <table id="datatable-buttons" class="table table-responsive table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Shipper</th>
                <th>Container No.</th>
                <th>Size</th>
                <th>Type</th>
                <th>In Date</th>
                <th>In Time</th>
                <th>Approval Date</th>
                <th>Available Date</th>
                <th>Status</th>
                <th>Transpoter In</th>
                <th>Truck In</th>
                <th>Party In</th>
                <th>Place In</th>
                <th>In Vessel</th>
                <th>Port From</th>
                <th>CHA</th>
                <th>Booking Remark</th>
                <th>Approval Amount</th>
                <th>No. Of Days In Depot</th>
                <th>Container In Remark</th>
                <th>Grade In</th>
                <th>Out Date</th>
                <th>Out Time</th>
                <th>Transporter Out</th>
                <th>Track Out</th>
                <th>Party Out</th>
                <th>Place Out</th>
                <th>Out Vessel</th>
                <th>Port To</th>
                <th>Seal No</th>
                <th>Grade Out</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @if ($data !== null)
            @foreach ($data as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->shipping_line}}</td>
                    <td>{{$item->container_no}}</td>
                    <td>{{$item->size}}</td>
                    <td>{{$item->container_type}}</td>
                    <td>{{date('d-M-Y',strtotime($item->in_date))}}</td>
                    <td>{{date('h:i A',strtotime($item->in_date))}}</td>
                    <td>
                        @if ($item->approval_date !== null)
                        {{date('d-M-Y',strtotime($item->approval_date))}}
                        @endif
                    </td>
                    <td>
                        @if ($item->av_date !== null)
                        {{date('d-M-Y',strtotime($item->av_date))}}
                        @endif
                    </td>
                    <td>{{$item->status}}</td>
                    <td>{{$item->transpoter}}</td>
                    <td>{{$item->vehicle}}</td>
                    <td>{{$item->consignee_party}}</td>
                    <td>{{$item->place}}</td>
                    <td>{{$item->vessel}}</td>
                    <td>{{$item->port_from}}</td>
                    <td>{{$item->cha}}</td>
                    <td>{{$item->booking_remark}}</td>
                    <td>{{$item->approval_amt}}</td>
                    <td>
                        @php
                        $no_of_days_in_depot = strtotime($end_date) - strtotime($item->in_date);
                        $diff = round($no_of_days_in_depot / 86400);
                        if ($diff < 0) {
                            $diff = 0;
                        }
                        @endphp
                        {{  $diff }}
                    </td>
                    <td>{{$item->container_remark}}</td>
                    <td>{{$item->grade}}</td>
                    @if ($item->out_date)
                    <td>{{date('d-M-Y',strtotime($item->out_date))}}</td>
                    <td>{{date('h:i A',strtotime($item->out_date))}}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                    <td>{{$item->out_transpoter}}</td>
                    <td>{{$item->out_vehicle}}</td>
                    <td>{{$item->out_consignee_party}}</td>
                    <td>{{$item->out_place}}</td>
                    <td>{{$item->out_vessel}}</td>
                    <td>{{$item->port_to}}</td>
                    <td>{{$item->seal_no}}</td>
                    <td>{{$item->out_grade}}</td>
                </tr>
            @endforeach
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
@endsection