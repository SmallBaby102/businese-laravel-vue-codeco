@extends('layout')
@section('title','Upload IAL File')
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
                            <li class="breadcrumb-item"><a href="javascript:;">Upload IAL File</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Upload IAL File</h4>
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
            <form action="{{route('upload-ial-file.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-2">
                        <label for="file">Choose IAL Excel File</label>
                        <input type="file" required class="form-control" name="file" id="file">
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="shipper">Shipping Line</label>
                            <select id="shipper" class="form-control" name="shipper">
                                <option value="">Select Shipping Line</option>
                                @foreach ($shipper as $item)
                                    <option value="{{$item->client_name}}">{{$item->client_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="import_do">Import Do</label>
                        <input type="text" required class="form-control" name="import_do" id="import_do">
                    </div>
                    <div class="col-2">
                        <label for="vessel">Vessel/Voy</label>
                        <input type="text" required class="form-control" name="vessel" id="vessel">
                    </div>
                    <div class="col-2">
                        <label for="voyage">Voyage</label>
                        <input type="text" required class="form-control" name="voyage" id="voyage">
                    </div>
                    <div class="col-2">
                        <label for="port">Port</label>
                        <input type="text" required class="form-control" name="port" id="port">
                    </div>
                </div>
                <input type="submit" value="Upload" class="btn btn-info">
            </form>
          </div>
        </div>

        @livewire('daily-report.ial-report-with-delete') 
</div>
</div>



@endsection