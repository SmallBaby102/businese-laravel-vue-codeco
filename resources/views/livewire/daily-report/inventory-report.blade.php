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
            <div class="col-3">
                <label for="datepicker">Select Date {{$result}}</label>
                <input class="form-control" wire:model='selected_date' type="date" name="" id="datepicker">
            </div>
            <div class="col-3">
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
            <div class="col-3">
                <div wire:loading wire:target="selected_date" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div wire:loading wire:target="lines" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>


    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table class="table table-striped table-bordered table-responsive">
                <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Shipper</th>
                    <th style="width:10%">Container No.</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th style="width:8%">In Date</th>
                    <th style="width:8%">In Time</th>
                    <th style="width:10%">Approval Date</th>
                    <th style="width:10%">Availabel Date</th>
                    <th style="width:6%">Status</th>
                    <th style="width:6%">Grade</th>
                    <th style="width:15%">Approval Amount</th>
                    <th style="width:15%">No. Of Days In Depot</th>
                    <th style="width:15%">Container In Remark</th>
                   
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
