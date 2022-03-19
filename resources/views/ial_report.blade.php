@extends('layout')
@section('title','IAL Report')
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
                            <li class="breadcrumb-item"><a href="#">IAL Report</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">IAL Report</h4>
                </div>
            </div>
        </div>
    @livewire('daily-report.ial-report')
</div>
</div>
@endsection