<div>
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="my-select">Shipping Line</label>
                        <select id="my-select" class="form-control" wire:model='shipping' name="">
                            <option value="">Select Shipping Line</option>
                            @foreach ($shipping_lines as $item)
                                <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <label for="start_date">Start Date</label>
                    <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input">
                </div>
                <div class="col-3">
                    <label for="end_date">End Date</label>
                    <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input">
                </div>
                <div class="col-3">
                    <br>
                    <button class="btn btn-info">Search</button>
                </div>
            </div>
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
                    <table class="table table-responsive table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><div class="form-check-inline my-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck7" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                        <label class="custom-control-label" for="customCheck7"></label>
                                    </div>
                                </div></th>
                                <th>Sr.No</th>
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
                            @if ($in_out_summary !== null)
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane p-3" id="profile" role="tabpanel">
                    <table class="table table-responsive table-striped table-bordered">
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
                    <table class="table table-responsive table-striped table-bordered">
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
                                    <td>{{$item->out_consignee_party}}</td>
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
