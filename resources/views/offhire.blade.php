@extends('layout')
@section('title','Offhire')
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
                            <li class="breadcrumb-item"><a href="#">Offhire</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Offhire</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        @livewire('offhire')
</div>
</div>
@endsection
