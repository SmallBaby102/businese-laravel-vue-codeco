@extends('layout')
@section('title','New User Register')
@section('content')
@section('header')
    @livewire('header')
@endsection
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">New User</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">All User</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
@livewire('create-user')
</div>
</div>
@endsection
