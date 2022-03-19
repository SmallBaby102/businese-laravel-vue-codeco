<div class="row">
    <div class="col-8">
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
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Size</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>ISO Code</th>
                            @if ((admin_varify(Auth::user()->type)))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item->size}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->iso_code}}</td>
                                @if ((admin_varify(Auth::user()->type)))
                                <td>
                                    <a href="javascript:;" wire:click="edit_data({{$item->id}})" class="btn btn-info"><i class="ion-edit"></i></a>
                                    <a href="javascript:;" onclick="confirm('Are You Sure You Want To Delete These Record ?') || event.stopImmediatePropagation()" wire:click="delete_data({{$item->id}})" class="btn btn-danger"><i class="ion-trash-a"></i></a>
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
    <div class="col-4">
        
        <div class="card">
            <div class="card-body">
                <div class="text-center mt-2 mb-3">
                    
                    <h4>Add Container Type</h4>
                    <div wire:loading wire:target="store">
                        Processing Payment...
                    </div>
                </div>
                <div class="p-3">
                    <form class="form-horizontal" wire:submit.prevent="store">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model='user_id'  type="hidden" required="" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="size" name="size" type="text" required="" placeholder="Enter Size">
                            </div>
                        </div>
                        @error('size')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="type" name="type" type="text" required="" placeholder="Enter Type">
                            </div>
                        </div>
                        @error('type')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="description" name="description" type="text" required="" placeholder="Enter Description">
                            </div>
                        </div>
                        @error('description')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="iso" name="iso" type="text" required="" placeholder="Enter ISO Code">
                            </div>
                        </div>
                        @error('iso')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        @if ((admin_varify(Auth::user()->type)))
                        <div class="form-group text-center row m-t-20">
                            <div class="col-6">
                                <button class="btn btn-info btn-block waves-effect waves-light" type="submit">Save</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:;" class="btn btn-danger btn-block waves-effect waves-light" wire:click='clear'>Clear</a>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
    
            </div>
        </div>
    </div>
</div> <!-- end container -->