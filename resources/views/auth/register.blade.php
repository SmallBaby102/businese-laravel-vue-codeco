@extends('layout')
@section('title','New User Register')
@section('content')
@section('header')
    @livewire('header')
@endsection
<div class="wrapper-page">
 
    <div class="card">
        <div class="card-body">

            <div class="text-center mt-2 mb-3">
                <h3>JMJ</h3>
                <p>Create New User Role</p>
            </div>

            <div class="p-3">
                <form class="form-horizontal" action="{{route('user.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('name')}}" name="name" type="text" required="" placeholder="Username">
                        </div>
                    </div>
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('name')}}" name="email" type="email" required="" placeholder="Email">
                        </div>
                    </div>
                    @error('email')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" name="password" type="password" required="" placeholder="Password">
                        </div>
                    </div>
                    @error('password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('phone')}}" name="phone" type="text" required="" placeholder="Phone Number">
                        </div>
                    </div>
                    @error('phone')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('company_name')}}" name="company_name" type="text" required="" placeholder="Company Name">
                        </div>
                    </div>
                    @error('company_name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('address')}}" name="address" type="text" required="" placeholder="Company Address">
                        </div>
                    </div>
                    @error('address')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" value="{{old('location')}}" name="location" type="text" required="" placeholder="Location">
                        </div>
                    </div>
                    @error('location')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group">
                      <select class="form-control" required name="role" id="">
                        <option value="">Select Role</option>
                        <option value="gate">Gate</option>
                        <option value="accounts">Accounts</option>
                        <option value="mnr">MNR</option>
                      </select>
                    </div>
                    @error('role')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Register</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>     
@endsection
            
        