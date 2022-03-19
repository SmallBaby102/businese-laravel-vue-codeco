@extends('layout')
@section('title','Estimate Data Import')
@section('header')
    @livewire('header')
@endsection
@section('content')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">Estimate Data Import</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Estimate Data Import</h4>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success">{{session('success')}}</div>
                </div>
            </div>
        @endif
        <div class="card text-left">
          <div class="card-body">
            <form action="{{route('upload_estimate_data_import')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-4 col-12">
                        <label for="file">Choose Excel File To Estimate Data Import</label>
                        <input type="file" required class="form-control" name="file" id="file">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 d-flex justify-content-between">
                        <input type="submit" value="Upload" class="btn btn-info">
                        <a download class="text-info mt-2" href="{{asset('assets/Estimate_data_import.xlsx')}}">Download Sample File</a>
                    </div>
                </div>
            </form>
          </div>
        </div>
</div>
</div>



@endsection