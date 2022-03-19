@extends('layout')
@section('title','Company Detail')
@section('content')
@section('header')
    @livewire('header')
@endsection
@section('content')
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <div class="px-3 pb-3">
                <form class="form-horizontal" action="{{route('company.store')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Company Name</label>
                            <input class="form-control" type="text" value="{{$data->company_name}}" name="company_name" value="" required="" placeholder="Company Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Company Adderess</label>
                      <textarea class="form-control" name="company_detail" name="company_detail" id="" placeholder="Company Detail" rows="3">{{$data->company_detail}}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Company E-mail</label>
                            <input class="form-control" type="email" value="{{$data->email}}" name="email" value="" required="" placeholder="Company E-mail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Company Contact No</label>
                            <input class="form-control" type="number" value="{{$data->phone}}" name="phone" value="" required="" placeholder="Company Contact No.">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Depot</label>
                            <input class="form-control" type="text" value="{{$data->depot}}" name="depot" value="" required="" placeholder="Company Depot">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Depot Code</label>
                            <input class="form-control" type="text" value="{{$data->depot_code}}" name="depot_code" value="" required="" placeholder="Company Depot Code">
                        </div>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            @if (admin_varify(Auth::user()->type))
                                <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Save</button>
                            @endif
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>      
</div> 
    
@endsection
