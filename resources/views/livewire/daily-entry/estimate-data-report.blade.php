<div>
    <div wire:loading wire:target="search">
        Processing Payment...
    </div>
    <?php
   $error_show = "";
        if($result > 0){
            $error_show = 'parsley-error';
            ?>
            <script>
                swal("{{$message}}", {
                    icon: "error",
                });
                console.log('{{$result}}');
            </script>
            <?php
        }
    ?>
    <form action="#" id="container_form_other" >
        <input type="hidden" name="" value="save-estimate-report" id="upload_url">
        <input type="hidden" name="container_id" value="{{$container_id}}">
        <input type="hidden" name="inventory_id" value="{{$inventory_id}}">
    <div class="card text-left">
        <div class="card-header">Container Information:</div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-2">
                    <label for="container">Container No.</label>
                    <input class="form-control" wire:keydown.enter="search($event.target.value)" value="" id="container_form" required name="container_no" type="text" >
                    
                </div>
                  <div class="col-2">
                      <div class="form-group">
                          <label for="size">Size</label>
                          <select class="custom-select"  disabled required name="size" id="size">
                            <option value="">Select Size</option>
                            @if ($size !== null)
                            <option value="{{$size}}" selected>{{$size}}</option>
                           @endif
                          </select>
                      </div>
                  </div>
                  <div class="col-2">
                      <div class="form-group">
                          <label for="type">Type</label>
                          <select class="custom-select"  disabled required name="type" id="type">
                            <option value="">Select Type</option>
                            @if ($type !== null)
                          <option value="{{$type}}" selected>{{$type}}</option>
                         @endif
                          </select>
                      </div>
                  </div>
                <div class="col-3">
                    <div class="form-group">
                      <label for="shipping">Shipping Line</label>
                      <select class="form-control " disabled required name="shipping" id="shipping">
                          <option value="">Select Shipping Line</option>
                          @if ($shipping !== null)
                          <option value="{{$shipping}}" selected>{{$shipping}}</option>
                         @endif
                      </select>
                    </div>
                </div>
                <div class="col-2">
                    <label>Depot</label>
                    @foreach ($company_detail as $item)
                    <input class="form-control" type="text" disabled value="{{$item->depot}}" id="">
                        <input class="form-control" type="hidden" value="{{$item->depot}}" name="depot" id="">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card text-left">
        <div class="card-header">Estimate Data Report</div>
      <div class="card-body">
            <div class="form-group row">
                <div class="col-2">
                    <label for="out_date">In Date</label>
                    <p>@if ($in_date !== null)
                        {{date('d M,Y H:i:s',strtotime($in_date))}}                        
                    @endif</p>
                </div>
                <div class="col-2"> 
                    <label for="es_date">Estimate Date</label>
                    <input class="form-control"  type="date" value="{{$data['estimate_date']}}" id="es_date" name="es_date"  >
                </div>
                <div class="col-2">
                    <label for="es_amount">Estimate Amount</label>
                    <input class="form-control"  type="number" value="{{$data['estimate_amount']}}" id="es_amount" name="es_amount"  >
                </div>
                <div class="col-2">
                    <label for="ap_date">AP Date</label>
                    <input class="form-control"  type="date" value="{{$data['approval_date']}}" id="ap_date" name="ap_date"  >
                </div>
                <div class="col-2">
                    <label for="ap_amount">AP Amount</label>
                    <input class="form-control"  type="number" value="{{$data['approval_amount']}}" id="ap_amount" name="ap_amount"  >
                </div>
                <div class="col-2">
                    <label for="av_date">AV Date</label>
                    <input class="form-control"  type="date" value="{{$data['av_date']}}" id="av_date" name="av_date"  >
                </div>
                
                
            </div>
            <div class="form-group row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="sstatus">Status</label>
                        <select class="form-control" required name="status"  id="sstatus">
                          <option value="">Select Status</option>
                      @if ($status !== null)
                        @if ($status == 'AE')
                            @php
                                $only_accept = ['AV','AP','UR','AV'];
                            @endphp
                            @foreach ($status_master as $it)
                                @if ($status == $it->status_code)
                                <option value="{{$it->status_code}}" selected>{{$it->status_detail}}</option>
                                @else
                                    @if (in_array($it->status_code,$only_accept))
                                        <option value="{{$it->status_code}}">{{$it->status_detail}}</option>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        @if ($status == 'AP')
                            @php
                                $only_accept = ['AP','UR','AV'];
                            @endphp
                            @foreach ($status_master as $it)
                                @if ($status == $it->status_code)
                                <option value="{{$it->status_code}}" selected>{{$it->status_detail}}</option>
                                @else
                                    @if (in_array($it->status_code,$only_accept))
                                        <option value="{{$it->status_code}}">{{$it->status_detail}}</option>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        @if ($status == 'UR')
                            @php
                                $only_accept = ['UR','AV'];
                            @endphp
                            @foreach ($status_master as $it)
                                @if ($status == $it->status_code)
                                <option value="{{$it->status_code}}" selected>{{$it->status_detail}}</option>
                                @else
                                    @if (in_array($it->status_code,$only_accept))
                                        <option value="{{$it->status_code}}">{{$it->status_detail}}</option>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        @if ($status == 'AV')
                            @php
                                $only_accept = ['AV'];
                            @endphp
                            @foreach ($status_master as $it)
                                @if ($status == $it->status_code)
                                <option value="{{$it->status_code}}" selected>{{$it->status_detail}}</option>
                                @else
                                    @if (in_array($it->status_code,$only_accept))
                                        <option value="{{$it->status_code}}">{{$it->status_detail}}</option>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                      @endif
                        </select>
                      </div>
                </div>
            </div>
      </div>
    </div>
    
      <div class="card text-left">
        <div class="card-body">
            @if ($result > 0)
                <button type="submit" disabled value="Save" class="btn btn-info">Save</button>
            @else
                <button type="submit" value="Save" class="btn btn-info">Save</button>
            @endif
            
        </div>
      </div>
    </form>
</div>
