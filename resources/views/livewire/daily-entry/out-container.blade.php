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
        <input type="hidden" name="" value="out-pass" id="upload_url">
    <div class="card text-left">
        <div class="card-header">Container Information:{{$message}}</div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-2">
                    <label for="container">Container No.</label>
                    <input class="form-control" wire:keydown.enter="search($event.target.value)" value="" required name="container_no" type="text" >
                    <input type="hidden" name="container_id" value="{{$container_id}}">
                    <input type="hidden" name="inventory_id" value="{{$inventory_id}}">
                    <input type="hidden" name="total_days" value="{{$total_days}}">
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
                            @if ($container_type !== null)
                                <option value="{{$container_type}}" selected>{{$container_type}}</option>
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
        <div class="card-header">Inward Information</div>
      <div class="card-body">
            <div class="form-group row">
                <div class="col-2">
                    <label for="in_date">In Date</label>
                    <p>{{$in_date}}</p>
                    <input value="" value="{{$in_date}}" name="in_date" type="hidden" >
                </div>
                <div class="col-3">
                    <label for="sstatus">Status</label>
                    <input class="form-control" disabled value="{{$in_status}}" type="text" id="sstatus" required name="sstatus"  >
                    {{-- <div class="form-group">
                        <label for="sstatus">Status</label>
                        <select class="form-control" disabled required name="sstatus"  id="sstatus">
                          <option value="">Select Status</option>
                          @if ($in_status !== null)
                          <option value="{{$in_status}}" selected>{{$in_status}}</option>
                         @endif
                        </select>
                      </div> --}}
                </div>
                <div class="col-3">
                    <label for="party">Consignee Party</label>
                    <input class="form-control" disabled value="{{$in_party}}" type="text" id="party" required name="party"  >
                </div>
                <div class="col-4">
                    <label for="place">Place</label>
                    <input class="form-control" disabled value="{{$in_place}}" id="place" required name="place" type="text" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-2">
                    <label for="vessel">Vessel/Voy</label>
                    <input class="form-control" disabled value="{{$in_vessel}}" id="vessel" required name="vessel" type="text" >
                </div>
                <div class="col-2">
                    <label for="port">Port From</label>
                    <input class="form-control" disabled value="{{$in_port}}" type="text" required id="port" name="port"  >
                </div>
                <div class="col-2">
                    <label for="cha">CHA</label>
                    <input class="form-control" disabled value="{{$in_cha}}" type="text" required id="cha" name="cha"  >
                </div>
                <div class="col-3">
                    <label for="transpoter">Transpoter</label>
                    <input class="form-control" disabled value="{{$in_transpoter}}" type="text" required id="transpoter" name="transpoter"  >
                </div>
                <div class="col-2">
                    <label for="vehicle">Vehicle</label>
                    <input class="form-control" disabled value="{{$in_vehicle}}" type="text" required id="vehicle" name="vehicle"  >
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select class="form-control" disabled required name="in_grade"  id="grade">
                          <option value="">Select grade</option>
                          @if ($in_grade !== null)
                          <option value="{{$in_grade}}" selected>{{$in_grade}}</option>
                         @endif
                        </select>
                      </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-3">
                    <label for="driver_name">Driver Name</label>
                    <input class="form-control" disabled value="{{$in_driver_name}}" required id="driver_name" name="driver_name" type="text" >
                </div>
                <div class="col-3">
                    <label for="driver_contact">Driver Contact</label>
                    <input class="form-control" disabled value="{{$in_driver_contact}}" type="text" required id="driver_contact" name="driver_contact"  >
                </div>
                <div class="col-3">
                    <label for="import_do">Import Do No</label>
                    <input class="form-control" disabled value="{{$import}}" type="text" required id="import_do" name="import_do"  >
                </div>
                <div class="col-3">
                    <label for="added">Added By</label>
                    <input class="form-control" disabled value="{{$in_added_by}}" type="text" disabled required name="added"  >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="container_remark">Container in remark</label>
                    <input class="form-control" disabled value="{{$in_container_remark}}" required id="container_remark" name="container_remark" type="text" >
                </div>
                <div class="col-6">
                    <label for="booking_remark">Booking Remark</label>
                    <input class="form-control" disabled value="{{$in_booking_remark}}" type="text" required id="booking_remark" name="booking_remark"  >
                </div>
            </div>
      </div>
    </div>
    <div class="card text-left">
        <div class="card-header">Out Ward Information</div>
      <div class="card-body">
            <div class="form-group row">
                <div class="col-2">
                    <label for="out_date">Out Date</label>
                    <p>{{date('d M,Y H:i:s')}}</p>
                </div>
                <div class="col-2">
                    <label for="out_ap_date">AP Date</label>
                    <input class="form-control" type="text" name="" disabled value="{{$ap_date}}" id="">
                    <input class="form-control"  type="hidden" value="{{$ap_date}}" id="out_ap_date" required name="out_ap_date"  >
                </div>
                <div class="col-2">
                    <label for="out_av_date">AV Date</label>
                    <input class="form-control" type="text" name="" disabled value="{{$av_date}}" id="">
                    <input class="form-control"  type="hidden" value="{{$av_date}}" id="out_av_date" required name="out_av_date"  >
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="out_status">Status</label>
                        <input type="text" class="form-control" name="" disabled value="{{$status}}" id="">
                    <input class="form-control"  type="hidden" value="{{$status}}" id="out_status" required name="out_status"  >
                      </div>
                </div>
               
                <div class="col-2">
                    <label for="out_shipper_party">Shipper Party</label>
                    <input class="form-control" value="" id="out_shipper_party" required name="out_shipper_party" type="text" >
                </div>
                <div class="col-2">
                    <label for="out_place">Place</label>
                    <input class="form-control" value="" id="out_place" required name="out_place" type="text" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-2">
                    <label for="out_vessel">Vessel/Voy</label>
                    <input class="form-control" value="" id="out_vessel" required name="out_vessel" type="text" >
                </div>
                <div class="col-2">
                    <label for="out_port">Port To</label>
                    <input class="form-control" value="" type="text" required id="out_port" name="out_port_to"  >
                </div>
                <div class="col-2">
                    <label for="out_eao">EAO/CONO</label>
                    <input class="form-control" value="" type="text" required id="out_eao" name="out_eao"  >
                </div>
                <div class="col-3">
                    <label for="out_transpoter">Transpoter</label>
                    <input class="form-control" value="" type="text" required id="out_transpoter" name="out_transpoter"  >
                </div>
                <div class="col-2">
                    <label for="out_vehicle">Vehicle</label>
                    <input class="form-control" value="" type="text" required id="out_vehicle" name="out_vehicle"  >
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="out_grade">Grade</label>
                        <select class="form-control" required name="out_grade"  id="out_grade">
                          <option value="">Select grade</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>
                      </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-3">
                    <label for="out_driver_name">Driver Name</label>
                    <input class="form-control" value="" required id="out_driver_name" name="out_driver_name" type="text" >
                </div>
                <div class="col-3">
                    <label for="out_driver_contact">Driver Contact</label>
                    <input class="form-control" value="" type="text" required id="out_driver_contact" name="out_driver_contact"  >
                </div>
                <div class="col-2">
                    <label for="export_do">Export Do No</label>
                    <input class="form-control" value="" type="text" required id="export_do" name="export_do"  >
                </div>
                <div class="col-2">
                    <label for="out_seal_no">Seal No</label>
                    <input class="form-control" value="" type="number" id="out_seal_no" required name="out_seal_no"  >
                </div>
                <div class="col-2">
                    <label for="out_challan_no">Challan No</label>
                    <input class="form-control" value="" type="number" required name="out_challan_no" id="out_challan_no" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="out_added">Final Destination</label>
                    <input class="form-control" type="text" name="final_dest" value="" id="">
                </div>
                <div class="col-4">
                    <label for="out_added">Original Port</label>
                    <input class="form-control" type="text" name="org_port" value="" id="">
                </div>
                <div class="col-2">
                    <label for="out_added">Added By</label>
                    <input class="form-control" type="text" name="" disabled value="{{Auth::user()->name}}" id="">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="out_container_remark">Remark Note</label>
                    <input class="form-control" value="" required id="out_container_remark" name="out_container_remark" type="text" >
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
</div>
