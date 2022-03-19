@extends('layout')
@section('title','Bulk Upload')
@section('content')
@section('header')
    @livewire('header')
@endsection
<div class="wrapper">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">Bulk Upload</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bulk Upload</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="card text-left">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-6">
                        <form action="{{route('bulk_upload.in')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="container">Choose File For In Container</label>
                            <input class="form-control"  value="" required name="in_file" type="file" >
                            <div class="mt-1 d-flex justify-content-between">
                                <input type="submit" value="Upload" class="btn btn-info">
                                <a download class="text-info" href="{{asset('assets/in.xlsx')}}">Download Sample File</a>
                            </div>
                            
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="{{route('bulk_upload.out')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="container">Choose File For Out Container</label>
                            <input class="form-control"  value="" required name="out_file" type="file" >
                            <div class="mt-1 d-flex justify-content-between">
                                <input type="submit" value="Upload" class="btn btn-info">
                                <a download class="text-info" href="{{asset('assets/out.xlsx')}}">Download Sample File</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
@endsection