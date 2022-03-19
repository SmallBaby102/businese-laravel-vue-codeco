@extends('layout')
@section('title','Total In Out Movement')
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
                            <li class="breadcrumb-item"><a href="javascript:;">Total In Out Movement</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Total In Out Movement</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        {{-- @livewire('daily-report.total-in-out-movement') --}}
        <div class="card">
            <div class="card-body">
                <form action="{{route('total_in_out_movement_fetch')}}" method="post">
                    @csrf
                <div class="form-group row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="my-select">Shipping Line</label>
                            <select id="my-select" class="form-control" name="shipping" id="shipping">
                                <option value="">Select Shipping Line</option>
                                @foreach ($shipping_lines as $item)
                                    @if ($shipping == $item->client_name)
                                        <option value="{{$item->client_name}}" selected>
                                    @else
                                        <option value="{{$item->client_name}}">
                                    @endif
                                        {{$item->client_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="start_date">Start Date</label>
                        <input class="form-control" type="datetime-local" value="{{$new_start_date}}" name="start_date" id="start_date">
                    </div>
                    <div class="col-3">
                        <label for="end_date">End Date</label>
                        <input class="form-control" type="datetime-local" value="{{$new_end_date}}" name="end_date" id="end_date">
                    </div>
                    <div class="col-3">
                        <br>
                        <button class="btn btn-info">Search</button>
                    </div>
                </div>
            </form>
            <form action="{{route('multi-sheets')}}" method="post">
                @csrf
                <input type="hidden" name="shipping_line" required value="{{$shipping}}">
                <input type="hidden" name="start_date" required value="{{$new_start_date}}">
                <input type="hidden" name="end_date" required value="{{$new_end_date}}">
                @if ($new_start_date)
                <input type="submit" class="btn btn-info" value="Export">
                @endif
            </form>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">In Out Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">In Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Out Details</a>
                    </li>
                </ul>
    
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="home" role="tabpanel">
                        <table id="datatable-buttons_1" class="table table-striped table-responsive table-bordered nowrap w-100 ">
                            <thead>
                                <tr>
                                    <th>Size / Type</th>
                                    <th>Opening</th>
                                    <th>Turnin's</th>
                                    <th>Turnout's</th>
                                    <th>Closing</th>
                                    <th>Awaiting Estimate</th>
                                    <th>Awaiting Approval</th>
                                    <th>Under Repair</th>
                                    <th>Available</th>
                                    <th>Totals</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($container_type as $item)
                                <tr>
                                    <td>{{$item->size.'/'.$item->type}}</td>
                                    @php
                                    if (!empty( $all_data )) {
                                        if (in_array($item->size,$size)) {
                                            if (in_array($item->size.$item->type,$type)) {
                                                echo '<td>'.$all_data[$item->size][$item->type]['opening'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['turnin'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['turnout'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['closing'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['AE'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['AP'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['UR'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['AV'].'</td>';
                                                echo '<td>'.$all_data[$item->size][$item->type]['total'].'</td>';
                                            } else {
                                                for ($i=0; $i <= 8; $i++) { 
                                                    echo '<td></td>';
                                                }
                                            }
                                        }else{
                                            for ($i=0; $i <= 8; $i++) { 
                                            echo '<td></td>';
                                            }
                                        }
                                    } else {
                                        for ($i=0; $i <= 8; $i++) { 
                                            echo '<td></td>';
                                        }
                                    }
                                    @endphp 
                                </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    @php
                                        if (!empty( $all_data )) {
                                            foreach ($all_total as $value) {
                                                echo '<td>'.$value.'</td>';
                                            }
                                        }
                                        else{
                                            for ($i=0; $i <= 8; $i++) { 
                                                echo '<td></td>';
                                            }
                                        }
                                    @endphp 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="profile" role="tabpanel">
                        <table id="datatable-buttons_2" class="table table-striped table-responsive table-bordered nowrap w-100 ">
                            <thead>
                                <tr>
                                    
                                    <th>Sr.No</th>
                                    <th>Container No.</th>
                                    <th>Size / Type</th>
                                    <th>In Date</th>
                                    <th>In Time</th>
                                    <th>Vehicle</th>
                                    <th>Place</th>
                                    <th>Transpoter</th>
                                    <th>Consignee</th>
                                    <th>Do No.</th>
                                    <th>Grade</th>
                                    <th>Remark</th>
                                    <th>In Vessel</th>
                                    <th>MGF Date</th>
                                    <th>Tare Weight</th>
                                    <th>Gross Weight</th>
                                    <th>Payload</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($in_details !== null)
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($in_details as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->container_no}}</td>
                                            <td>{{$item->size.' / '.$item->container_type}}</td>
                                            <td>{{date('d-m-Y', strtotime($item->in_date))}}</td>
                                            <td>{{date('h:i A', strtotime($item->in_date))}}</td>
                                            <td>{{$item->vehicle}}</td>
                                            <td>{{$item->place}}</td>
                                            <td>{{$item->transpoter}}</td>
                                            <td>{{$item->consignee_party}}</td>
                                            <td>{{$item->import_do}}</td>
                                            <td>{{$item->grade}}</td>
                                            <td>{{$item->booking_remark}}</td>
                                            <td>{{$item->vessel}}</td>
                                            <td>{{$item->mfg_date}}</td>
                                            <td>{{$item->tare}}</td>
                                            <td>{{$item->max_gross}}</td>
                                            <td>{{$item->payload}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="messages" role="tabpanel">
                        <table id="datatable-buttons_3" class="table table-striped table-responsive table-bordered nowrap w-100 ">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Container No.</th>
                                    <th>Size / Type</th>
                                    <th>In Date</th>
                                    <th>Out Date</th>
                                    <th>Status</th>
                                    <th>Port</th>
                                    <th>No Of Days</th>
                                    <th>Vessel</th>
                                    <th>Out Time</th>
                                    <th>Vehicle No.</th>
                                    <th>Destination</th>
                                    <th>Transpoter</th>
                                    <th>Shipper</th>
                                    <th>Do No</th>
                                    <th>Seal No</th>
                                    <th>Remarks</th>
                                    <th>Grade</th>
                                    <th>EAO/CONO</th>
                                    <th>MGF Date</th>
                                    <th>Tare Weight</th>
                                    <th>Gross Weight</th>
                                    <th>Payload</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($out_details !== null)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($out_details as $item)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$item->container_no}}</td>
                                        <td>{{$item->size.' / '.$item->container_type}}</td>
                                        <td>{{date('d-m-Y', strtotime($item->in_date))}}</td>
                                        <td>{{date('d-m-Y', strtotime($item->out_date))}}</td>
                                        <td>{{$item->out_status}}</td>
                                        <td>{{$item->out_depot}}</td>
                                        <td>{{$item->no_of_days_in_depot}}</td>
                                        <td>{{$item->out_vessel}}</td>
                                        <td>{{date('h:i A', strtotime($item->out_date))}}</td>
                                        <td>{{$item->out_vehicle}}</td>
                                        <td>{{$item->port_to}}</td>
                                        <td>{{$item->out_transpoter}}</td>
                                        <td>{{$item->shipping_line}}</td>
                                        <td>{{$item->export_do}}</td>
                                        <td>{{$item->seal_no}}</td>
                                        <td>{{$item->remak_note}}</td>
                                        <td>{{$item->out_grade}}</td>
                                        <td>{{$item->eao_cono}}</td>
                                        <td>{{$item->mfg_date}}</td>
                                        <td>{{$item->tare}}</td>
                                        <td>{{$item->max_gross}}</td>
                                        <td>{{$item->payload}}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
    
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