<div>
    <div class="card">
        @if (session()->has('success'))
        <div class="card">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    <strong>{{session('success')}}</strong>
                </div>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    <strong>{{session('error')}}</strong>
                </div>
            </div>
        </div>
    @endif
    @if ((admin_varify(Auth::user()->type)))
        <div class="card-body">
            <div id="accordion-2" role="tablist">
                <div class="card shadow-none border mb-0">
                    <div class="card-header" role="tab" id="heading-7">
                        <h5 class="mb-0 mt-0 font-weight-normal">
                            <a data-toggle="collapse" href="#collapse-7" aria-expanded="false" aria-controls="collapse-7" class="collapsed">
                                Add New Company
                            </a>
                        </h5>
                    </div>
                    @php
                        $show = "collapse";
                        if($coll == 1){
                            $show = 'show';
                        }
                    @endphp
                    <div id="collapse-7" class="{{$show}}" role="tabpanel" aria-labelledby="heading-7" data-parent="#accordion-2" style="">
                        <div class="card-body">
                            <form class="form-horizontal" wire:submit.prevent="store">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-2">
                                        <input class="form-control" wire:model='code' name="code" type="text" required="" placeholder="Code">
                                        @error('code')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" wire:model='client_name' name="client_name" type="text" required="" placeholder="Client Name">
                                        @error('client_name')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control" wire:model='email' name="email" type="email" required="" placeholder="E-mail ID">
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" wire:model='phone' name="phone" type="number" required="" placeholder="Contact No.">
                                        @error('phone')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-8">
                                        <input class="form-control" wire:model='address' name="address" type="text" required="" placeholder="Address">
                                        @error('address')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input class="form-control" wire:model='city' name="city" type="text" required="" placeholder="City">
                                        @error('city')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input class="form-control" wire:model='pincode' name="pincode" type="number" required="" placeholder="Pincode">
                                        @error('pincode')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <input class="form-control" wire:model='b_l' name="b_l" type="text" required="" placeholder="B/L">
                                        @error('b_l')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" wire:model='group' name="group" type="text" required="" placeholder="Group">
                                        @error('group')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" wire:model='cont_press' name="cont_press" type="text" required="" placeholder="Cont Press">
                                        @error('cont_press')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" wire:model='loc' name="loc" type="text" required="" placeholder="LOC">
                                        @error('loc')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group text-center row m-t-20">
                                    <div class="col-6">
                                        <button class="btn btn-info btn-block waves-effect waves-light" type="submit">Save</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:;" class="btn btn-danger btn-block waves-effect waves-light" wire:click='clear'>Clear</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        @endif
    </div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Code</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>City</th>
                            <th>Pincode</th>
                            <th>B/L</th>
                            <th>Group</th>
                            <th>Cont Pers</th>
                            <th>LOC</th>
                            <th>Address<th>
                            @if ((admin_varify(Auth::user()->type)))
                                <th>Action</th>
                            @endif
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i =1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->client_name}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->city}}</td>
                                <td>{{$item->pincode}}</td>
                                <td>{{$item->b_l}}</td>
                                <td>{{$item->company_group}}</td>
                                <td>{{$item->cont_pers}}</td>
                                <td>{{$item->loc_code}}</td>
                                <td>{{$item->address}}</td>
                                @if ((admin_varify(Auth::user()->type)))
                                <td>
                                    <a href="javascript:;" wire:click="edit_data({{$item->id}})" class="btn btn-info" ><i class="ion-edit"></i></a>
                                    <a href="javascript:;"  onclick="confirm('Are You Sure You Want To Delete These Record ?') || event.stopImmediatePropagation()" wire:click="delete_data({{$item->id}})" class="btn btn-danger"><i class="ion-trash-a"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">{{$data->links()}}</div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <!--  Modal content for the above example -->
    

</div> <!-- end container -->

</div>