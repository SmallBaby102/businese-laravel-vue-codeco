<div>
    <div wire:loading wire:target="search">
        Processing Payment...
    </div>
    <?php
    $error_show = "";
    $modal_show = '';
        if($result > 0 ){
            $error_show = 'parsley-error';
            ?>
            <script>
                swal('{{$message}}', {
                    icon: "error",
                });
                console.log({{$result}});
            </script>
            <?php
        }
        if($gate_pass_no == null){
            $gate_pass_no = 1;
        }else{
            $gate_pass_no++;
        }
        if($gate_pass_no_in == null){
            $gate_pass_no_in = 1;
        }else{
            $gate_pass_no_in++;
        }
    ?>
    <form action="#" id="container_form" >
        <input type="hidden" name="container_type" value="{{$type}}">
        <input type="hidden" name="" value="gate-pass" id="upload_url">
        <input type="hidden" name="" value="gate-pass-preview" id="preview_url">
        <input type="hidden" name="gate_pass_no" value="{{$gate_pass_no}}">
        <input type="hidden" name="gate_pass_no_in" value="{{$gate_pass_no_in}}">
    <div class="card text-left">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-3">
                    <div class="form-group">
                      <label for="shipping">Shipping Line </label>
                      <select class="form-control {{$error_show}}" required name="shipping" id="shipping">
                          <option value="">Select Shipping Line</option>
                          @if ($party !== null)
                          <option value="{{$party}}" selected>{{$party}}</option>
                          @else
                            @foreach ($line_master as $item)
                                <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                            @endforeach
                          @endif
                      </select>
                    </div>
                </div>
                <div class="col-3">
                    <label></label>
                    @foreach ($company_detail as $item)
                    <h6>Depot : {{ ucfirst(trans($item->depot)) }}</h6>
                        <input class="form-control" type="hidden" value="{{$item->depot}}" name="depot" id="">
                        <input class="form-control" type="hidden" value="{{$item->depot_code}}" name="depot_code" id="">
                    @endforeach
                </div>
                <div class="col-3">
                    <label></label>
                    <h6>Added By : {{ ucfirst(trans(Auth::user()->name)) }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-left">
        <div class="card-header">Inward Information</div>
      <div class="card-body">
            <div class="form-group row">
                <div class="col-3">
                    <label for="consignee">Consignee Party</label>
                    <input class="form-control" value="" required id="consignee" name="consignee" type="text" >
                </div>
                <div class="col-3">
                    <label for="place">Place</label>
                    <input class="form-control" value="" type="text" required name="place"  >
                </div>
                <div class="col-3">
                    <label for="vessel">Vessel/Voy</label>
                    <input class="form-control {{$error_show}}" value="{{$vessel}}" type="text" id="vessel" required name="vessel"  >
                </div>
                <div class="col-3">
                    <div class="form-check-inline my-2 mt-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck6" data-parsley-multiple="groups" data-parsley-mincheck="2">
                            <label class="custom-control-label" for="customCheck6">Repeat vessel into consignee</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-3">
                    <label for="transpoter">Transporter</label>
                    <input class="form-control" value="" required name="transpoter" type="text" >
                </div>
                <div class="col-3">
                    <label for="vehicle">Vehicle #</label>
                    <input class="form-control" value="" type="text" required name="vehicle"  >
                </div>
                <div class="col-6">
                    <label for="booking">Booking/Remark</label>
                    <input class="form-control" value="" type="text" required name="booking"  >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-3">
                    <label for="port">Port From</label>
                    <input class="form-control {{$error_show}}" value="{{$port}}" required name="port" type="text" >
                </div>
                <div class="col-3">
                    <label for="cha">CHA</label>
                    <input class="form-control" value="" type="text" required name="cha"  >
                </div>
                <div class="col-3">
                    <label for="driver">Driver Name</label>
                    <input class="form-control" value="" type="text" required name="driver"  >
                </div>
                <div class="col-3">
                    <label for="driver_phone">Driver Contact</label>
                    <input class="form-control" value="" type="number" required name="driver_phone"  >
                </div>
            </div>
      </div>
    </div>
    <div class="card text-left">
        <div class="card-header">Container 1</div>
        <div class="card-body">
              <div class="form-group row">
                  <div class="col-3">
                      <label for="container">Container No.</label>
                      <input class="form-control" wire:keydown.enter="search($event.target.value)" value="" required name="container_no[]" type="text" >
                      <input type="hidden" name="ial_upload_id[]" value="{{$ial_upload_id}}">
                  </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="size">Size</label>
                            <select class="custom-select"  required name="size[]" id="size">
                                @php
                                    $size_arr = [];
                                @endphp
                                @if ($size_1 !== null)
                                    <option value="{{$size_1}}" selected>{{$size_1}}</option>
                                @else
                                    <option value="">Select Size</option>
                                    @foreach ($container_type as $item)
                                        @if (!in_array($item->size,$size_arr))
                                            
                                        <option value="{{$item->size}}">{{$item->size}}</option>
                                        @php
                                            $size_arr[] = $item->size;
                                        @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="custom-select"  required name="type[]" id="type">
                                @php
                                    $type_arr = [];
                                @endphp
                                @if ($type_1 !== null)
                                <option value="{{$type_1}}" selected>{{$type_1}}</option>
                                @else
                                    <option value="">Select Type</option>
                                    @foreach ($container_type as $item)
                                        @if (!in_array($item->type,$type_arr))
                                            
                                        <option value="{{$item->type}}">{{$item->type}}</option>
                                        @php
                                            $type_arr[] = $item->type;
                                        @endphp
                                        @endif
                                    @endforeach
                                @endif
                                    
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                          <label for="sstatus">Status</label>
                          <select class="form-control" required name="sstatus[]"  id="sstatus">
                            <option value="">Select Status</option>
                            @foreach ($status_master as $item)
                                @if ($item->status_code == 'AE')
                                <option value="{{$item->status_code}}" selected>
                                @else    
                                <option value="{{$item->status_code}}">
                                @endif
                                {{$item->status_detail}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
              </div>
              <div class="form-group row">
                  <div class="col-2">
                      <label for="gross">Max Gross WT.</label>
                      <input class="form-control" value="" required name="gross[]" type="number" >
                  </div>
                  <div class="col-2">
                      <label for="tare">Tare WT.</label>
                      <input class="form-control" value="" type="number" required name="tare[]"  >
                  </div>
                  <div class="col-2">
                      <label for="mfg">MFG Date</label>
                      <input class="form-control" value="" type="date" required name="mfg[]"  >
                  </div>
                  <div class="col-2">
                    <label for="csc">CSC Date</label>
                    <input class="form-control" required name="csc[]" value="" id="csc" type="date" >
                </div>
                <div class="col-2">
                    <label for="payload">PAYLOAD</label>
                    <input class="form-control" required name="payload[]" value="" id="payload" type="text" >
                </div>
                <div class="col-2">
                    <label for="import_do">IMPORT DO No.</label>
                    <input class="form-control" required name="import[]" value="{{$import_1}}" id="import_do" type="text" >
                </div>
              </div>
              <div class="form-group row">
                  <div class="col-10">
                      <label for="container_remark">Container In Remark</label>
                      <input class="form-control" required name="container_remark[]" value="" id="container_remark" type="text" >
                  </div>
                  <div class="col-2">
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select class="form-control" required name="grade[]"  id="grade">
                          <option value="">Select grade</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>
                      </div>
                </div>
              </div>
        </div>
      </div>
      <div class="card text-left">
        <div class="card-header">Container 2</div>
        <div class="card-body">
              <div class="form-group row">
                  <div class="col-3">
                      <label for="container">Container No.</label>
                      <input class="form-control" wire:keydown.enter="search_2($event.target.value)" name="container_no[]" value=""  id="container_2" type="text" >
                      <input type="hidden" name="ial_upload_id[]" value="{{$ial_upload_id_2}}">
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                        <label for="size">Size</label>
                        <select class="custom-select" name="size[]" id="size">
                            @php
                                $size_arr = [];
                            @endphp
                            @if ($size_2 !== null)
                                <option value="{{$size_2}}" selected>{{$size_2}}</option>
                            @else
                                <option value="">Select Size</option>
                                @foreach ($container_type as $item)
                                    @if (!in_array($item->size,$size_arr))
                                        
                                    <option value="{{$item->size}}">{{$item->size}}</option>
                                    @php
                                        $size_arr[] = $item->size;
                                    @endphp
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="custom-select" name="type[]" id="type">
                            @php
                                $type_arr = [];
                            @endphp
                            @if ($type_2 !== null)
                            <option value="{{$type_2}}" selected>{{$type_2}}</option>
                            @else
                                <option value="">Select Type</option>
                                @foreach ($container_type as $item)
                                    @if (!in_array($item->type,$type_arr))
                                        
                                    <option value="{{$item->type}}">{{$item->type}}</option>
                                    @php
                                        $type_arr[] = $item->type;
                                    @endphp
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                      <label for="sstatus">Status</label>
                      <select class="form-control" name="sstatus[]" id="sstatus">
                        <option value="">Select Status</option>
                        @foreach ($status_master as $item)
                            @if ($item->status_code == 'AE')
                            <option value="{{$item->status_code}}" selected>
                            @else    
                            <option value="{{$item->status_code}}">
                            @endif
                            {{$item->status_detail}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                 
              </div>
              <div class="form-group row">
                  <div class="col-2">
                      <label for="gross">Max Gross WT.</label>
                      <input class="form-control" name="gross[]" value="" id="gross" type="number">
                  </div>
                  <div class="col-2">
                      <label for="tare">Tare WT.</label>
                      <input class="form-control" name="tare[]" value="" type="number" id="tare">
                  </div>
                  <div class="col-2">
                      <label for="mfg">MFG Date</label>
                      <input class="form-control" name="mfg[]" value="" type="date" id="mfg">
                  </div>
                  <div class="col-2">
                    <label for="csc">CSC Date</label>
                    <input class="form-control" name="csc[]" value="" id="csc" type="date">
                </div>
                <div class="col-2">
                    <label for="payload">PAYLOAD</label>
                    <input class="form-control" name="payload[]" value="" id="payload" type="text">
                </div>
                <div class="col-2">
                    <label for="import_do">IMPORT DO No.</label>
                    <input class="form-control" wire:model='import_2' name="import[]" value="{{$import_2}}" id="import_do" type="text">
                </div>
              </div>
              <div class="form-group row">
                  <div class="col-10">
                      <label for="container_remark">Container In Remark</label>
                      <input class="form-control" name="container_remark[]" value="" id="container_remark" type="text">
                  </div>
                  <div class="col-2">
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select class="form-control" name="grade[]"  id="grade">
                          <option value="">Select grade</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>
                      </div>
                </div>
              </div>
        </div>
      </div>
      <div class="card text-left">
        <div class="card-body">
            <button type="submit" value="Save" class="btn btn-info">Save</button>
        </div>
      </div>
    </form>


    
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Review Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="model_body">

                </div>
                <div class="mt-3">
                    <a href="javascript:;" class="btn btn-info" data-dismiss="modal" aria-hidden="true">Edit</a>
                    <a href="javascript:;" class="btn btn-success" id="container_save">Submit</a>
                </div>
            </div>
          </div>
        </div>
      </div>
  

</div>
