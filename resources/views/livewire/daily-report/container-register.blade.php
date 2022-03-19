<div>
    
    <?php
    
        if($result > 0 ){
            ?>
            <script>
                swal('{{$message}}', {
                    icon: "error",
                });

            </script>
            <?php
        }
        
    ?>
    <div class="card text-left">
      <div class="card-body">
        <div class="form-group row">
            <div class="col-2">
                <label for="datepicker">Select Start Date</label>
                <input class="form-control" wire:model='selected_start_date' type="date" name="" id="datepicker">
            </div>
            <div class="col-2">
                <label for="datepicker">Select End Date</label>
                <input class="form-control" wire:model='selected_end_date' type="date" name="" id="datepicker">
            </div>
            <div class="col-2">
                <label for="shipping_line">Shipping Line</label>
                <div class="form-group">
                  <select class="form-control" wire:model='lines' name="" id="shipping">
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
                  <select class="form-control" wire:model='status' name="" id="sstatus">
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
                  <select class="form-control" wire:model='check_table' name="" id="check_table">
                    <option value="1" selected>In Records</option>
                    <option value="2" >Out Records</option>
                    <option value="3" selected>Combine Records</option>
                    <option value="4" selected>Availabel Date</option>
                  </select>
                </div>
            </div>
            <div class="col-2">
                <label for=""></label><br>
                <a href="javascript:;" wire:click='export' class="btn btn-info">Excel Export</a>
            </div>
            <div class="col-2">
                {{-- <button class="btn btn-info mt-4" wire:click='search'>Search</button> --}}
                <div wire:loading wire:target="selected_end_date" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div wire:loading wire:target="lines" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div wire:loading wire:target="status" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div wire:loading wire:target="check_table" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="card text-left">
      <div class="card-body">
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th class="w-25"><div class="form-check-inline my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck7" data-parsley-multiple="groups" data-parsley-mincheck="2">
                            <label class="custom-control-label" for="customCheck7"></label>
                        </div>
                    </div></th>
                    <th>Sr.No</th>
                    <th class="w-25">Shipper</th>
                    <th>Container No.</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>In Date</th>
                    <th>In Time</th>
                    <th class="w-25">Approval Date</th>
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
                @if ($this->data !== null)
                @foreach ($this->data as $item)
                    <tr>
                        <td><div class="form-check-inline my-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="{{$item->id}}" class="custom-control-input" wire:model='check' id="customCheck{{$item->id}}" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                <label class="custom-control-label" for="customCheck{{$item->id}}"></label>
                            </div>
                        </div></td>
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
                            $no_of_days_in_depot = strtotime($selected_end_date) - strtotime($item->in_date);
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
    
        @if ($this->data !== null)
        <div class="row">{{$this->data->links('')}}</div>
        @endif
        
      </div>
    </div>

    
</div>
