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
                            <th>Priority</th>
                            <th>Status Detail</th>
                            <th>Status Code</th>
                            @if ((admin_varify(Auth::user()->type)))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->priority}}</td>
                                <td>{{$item->status_detail}}</td>
                                <td>{{$item->status_code}}</td>
                                @if ((admin_varify(Auth::user()->type)))
                                <td>
                                    <a href="javascript:;" wire:click="edit_data({{$item->id}})" class="btn btn-info"><i class="ion-edit"></i></a>
                                    <a href="javascript:;" onclick="confirm('Are You Sure You Want To Delete These Record ?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click="delete_data({{$item->id}})"><i class="ion-trash-a"></i></a>
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
                    
                    <h4>Add Status Master</h4>
                    <div wire:loading wire:target="store">
                        Processing Payment...
                    </div>
                </div>
                <div class="p-3">
                    <form class="form-horizontal" wire:submit.prevent="store">
                        @csrf
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model='user_id' value="{{$user_id}}" type="hidden" required="" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="priority" name="priority" type="text" required="" placeholder="Priority">
                            </div>
                        </div>
                        @error('priority')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="status_detail" name="status_detail" type="text" required="" placeholder="Status Detail">
                            </div>
                        </div>
                        @error('status_detail')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model="status_code" name="status_code" type="text" required="" placeholder="Status Code">
                            </div>
                        </div>
                        @error('status_code')
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