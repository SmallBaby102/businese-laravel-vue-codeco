<div>
    <div wire:loading wire:target="view_data">
        Processing System...
    </div>
    <div class="card text-left">
      <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>IMPORT DO NO.</th>
                    <th>LINES</th>
                    <th>VESSEL</th>
                    <th>PORT</th>
                    <th>SIZE</th>
                    <th>TYPE</th>
                    <th>QTY</th>
                    <th>REACHED</th>
                    <th>PENDING</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i =1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->import_do}}</td>
                        <td>{{$item->shipper}}</td>
                        <td>{{$item->vessel}}</td>
                        <td>{{$item->port}}</td>
                        @php
                            $qty = json_decode($item->total_container,true);
                            $qty = count($qty);
                            $reached = count(json_decode($item->reached,true));
                            $pending = $qty - $reached;
                        @endphp
                        <td>{{$item->size}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$qty}}</td>
                        <td>{{$reached}}</td>
                        <td>{{$pending}}</td>
                        <td>
                            
                            <a href="javascript:;" wire:click="view_data({{$item->id}})" class="btn btn-info" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg"><i class="ion-eye"></i></a>
                            {{-- <a href="javascript:;" class="btn btn-danger"><i class="ion-trash-a"></i></a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">{{$data->links()}}</div>
      </div>
    </div>

@php
    $coll = '';
    $block = 'none';
    if ($show == 1) {
        $coll = 'show';
        $block = 'block';
    }
@endphp

    <div class="modal fade bs-example-modal-lg {{$coll}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: {{$block}};" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Company Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                       <table class="table">
                           <thead>
                               <tr>
                                   <th>Container No</th>
                                   <th>Size</th>
                                   <th>Type</th>
                                   <th>In Date</th>
                               </tr>
                           </thead>
                           <tbody>
                               @php
                               if ($show == 1) {
                                   $v_container = json_decode($container_no,true);
                                   $v_size = json_decode($size,true);
                                   $v_type = json_decode($type,true);
                                   $v_reached = json_decode($container_reached,true);
                                   $result = "";
                                   for ($i=0; $i < count($v_container); $i++) { 
                                       $result .='
                                        <tr>
                                            <td>'.$v_container[$i].'</td>
                                            <td>'.$size.'</td>
                                            <td>'.$type.'</td>
                                            <td>';
                                                if ($v_reached !== null) {
                                                    foreach ($v_reached as $key => $value) {
                                                        foreach ($value as $k => $v) {
                                                            if ($k == $v_container[$i]) {
                                                                $result .=date('d-M-Y',strtotime($v));
                                                            }
                                                        }
                                                    }
                                                }
                                            $result .='</td>
                                        </tr>
                                       ';
                                   } 
                                   echo $result;

                                }
                               @endphp
                           </tbody>
                       </table> 
                        
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
