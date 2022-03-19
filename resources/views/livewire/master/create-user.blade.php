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
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i =1;
                        @endphp
                        @foreach ($data as $item)
                            @if (Auth::user()->type == 'super_admin' || $item->type !== 'super_admin')
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <p class="text-success">Active</p>
                                        @else
                                            <p class="text-danger">Not Active</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" wire:click="edit_data({{$item->id}})" class="btn btn-info"><i class="ion-edit"></i></a>
                                        <a href="javascript:;" onclick="confirm('Are You Sure You Want To Suspend These Record ?') || event.stopImmediatePropagation()" wire:click="suspend_data({{$item->id}})" class="btn btn-warning text-black"><i class="ion-eye-disabled"></i></a>
                                        <a href="javascript:;"  onclick="confirm('Are You Sure You Want To Delete These Record ?') || event.stopImmediatePropagation()" wire:click="delete_data({{$item->id}})" class="btn btn-danger"><i class="ion-trash-a"></i></a>
                                    </td>
                                </tr>
                            @endif
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
                    
                    <h4>Create New User Role</h4>
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
                                <input class="form-control" wire:model='name' value="{{$name}}" name="name" type="text" required="" placeholder="Username">
                            </div>
                        </div>
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model='email' value="{{$email}}" name="email" type="email" required="" placeholder="Email">
                            </div>
                        </div>
                        @error('email')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model='password' type="password" required="" placeholder="Password">
                            </div>
                        </div>
                        @error('password')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control" wire:model='phone' name="phone" type="text" required="" placeholder="Phone Number">
                            </div>
                        </div>
                        @error('phone')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        <div class="form-group">
                          <select class="form-control" wire:model='role' name="role" id="">
                            <option value="">Select Role</option>
                              @if ($role)
                                <option value="{{$role}}" selected>{{$role}} </option>                                 
                              @endif
                              <option value="gate">Gate</option>
                              <option value="accounts">Accounts</option>
                              <option value="mnr">MNR</option>
                            </option>
                            
                          </select>
                        </div>
                        @error('role')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
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
</div> <!-- end container -->