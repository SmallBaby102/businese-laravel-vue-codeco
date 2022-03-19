<div>
    @if ($result > 0)
        {{dd($this->message)}}
    @endif
    
    <div class="card text-left">
        <div class="card-body">
            <form action="{{route('offhire_save')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-group row">
                <div class="col-4">
                    <label for="container">Select Excel File</label>
                    <input class="form-control"  value="" wire:model='file' required name="file" type="file" >
                </div>
                
                    <div class="col-2">
                        <div class="form-group">
                        <label for="shipping">Shipping Line From</label>
                        <select class="form-control " required name="shipping_from" id="shipping">
                            <option value="">Select Shipping Line</option>
                            @if ($shipping !== null)
                            <option value="{{$shipping}}" selected>{{$shipping}}</option>
                            @endif
                        </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                        <label for="shipping">Shipping Line To</label>
                        <select class="form-control " required name="shipping_to" id="shipping">
                            <option value="">Select Shipping To</option>
                            @if ($ship !== null)
                            @foreach ($ship as $item)
                                @if ($shipping == $item->client_name)
                                @else
                                    <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                                @endif
                            @endforeach
                            @endif
                        </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="date">Offhire Date</label>
                        <input type="date" name="offhire" required class="form-control" id="">
                    </div>
                    <div class="col-2">
                        <input type="submit" value="OFFHIRE" class="btn btn-info m-4">
                    </div>
                <div class="col-2">
                    <div wire:loading wire:target="upload" class="spinner-border text-primary mt-4" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 d-flex justify-content-between">
                    <a href="javascript:;" class="btn btn-info mt-2" wire:click='upload'>Upload</a>
                    <a download class="text-info mt-2" href="{{asset('assets/offhire.xlsx')}}">Download Sample Flie</a>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="card text-left">
        <div class="card-header">Container Information:</div>
        <div class="card-body">
           <table class="table">
               <thead>
                   <tr>
                       <th>Container No</th>
                       <th>Size</th>
                       <th>Type</th>
                       <th>Status</th>
                   </tr>
               </thead>
               <tbody>
                   @if ($this->data !== null)
                       @foreach ($this->data as $item)
                           <tr>
                               <td>{{$item['container_no']}}</td>
                               <td>{{$item['size']}}</td>
                               <td>{{$item['type']}}</td>
                               <td>{{$item['status']}}</td>
                           </tr>
                       @endforeach
                   @endif
               </tbody>
           </table>
        </div>
    </div>
    
</div>
