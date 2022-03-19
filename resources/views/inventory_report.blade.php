@extends('layout')
@section('title','Inventory Report')
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
                            <li class="breadcrumb-item"><a href="#">Inventory Report</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Inventory Report</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        {{-- @livewire('daily-report.inventory-report') --}}
        <div class="card text-left">
            <div class="card-body">
                <form action="{{route('inventory_report_fetch')}}" method="post">
                    @csrf
              <div class="form-group row">
                  <div class="col-3">
                      <label for="datepicker">Select Date</label>
                      @php
                        $date = '';
                          if($selected_date){
                            $date = $selected_date;
                          }
                      @endphp
                      <input class="form-control"  type="date" value="{{$date}}" required name="date" id="datepicker">
                  </div>
                  <div class="col-3">
                      <label for="shipping_line">Shipping Line</label>
                      <div class="form-group">
                        <select class="form-control"  name="shipping" id="shipping">
                          <option value="all" selected>All</option>
                            @foreach ($shipping as $item)
                                <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-3">
                    <br>
                    <input type="submit" value="Search" class="btn btn-info">   
                  </div>
              </div>
            </form>
            </div>
          </div>
      
      
          <div class="row">
              <div class="col-12">
                <div class="card">
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
                          <th>Availabel Date</th>
                          <th>Status</th>
                          <th>Grade</th>
                          <th>Approval Amount</th>
                          <th>No. Of Days In Depot</th>
                          <th>Container In Remark</th>
                         
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
                              <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                              <td>{{date('h:i A',strtotime($item->created_at))}}</td>
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
                              <td>{{$item->grade}}</td>
                              <td>{{$item->approval_amt}}</td>
                              <td>
                                  @php
                                  $no_of_days_in_depot = strtotime($selected_date) - strtotime($item->in_date);
                                  $diff = round($no_of_days_in_depot / 86400);
                                  if ($diff < 0) {
                                      $diff = 0;
                                  }
                                  @endphp
                                  {{  $diff }}
                              </td>
                              <td>{{$item->container_remark}}</td>
                          </tr>
                      @endforeach
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- end col -->
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
