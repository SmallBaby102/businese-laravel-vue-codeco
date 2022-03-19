@extends('layout')
@section('title','Login')
    @section('content')
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body">

                    <div class="text-center mt-2 mb-4">
                        <h3>DIGILIYO TECHNOLOGIES</h3>
                    </div>
                    <x-jet-validation-errors class="mb-4" />
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="px-3 pb-3">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" name="email" value="{{old('email')}}" required="" placeholder="E-mail">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                                        <label class="custom-control-label" for="remember_me">Remember me</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-7 m-t-20">
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your password ?</small></a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>      
        </div> 
    @endsection
            
        