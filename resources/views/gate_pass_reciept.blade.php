@extends('layout')
@section('title','Gate Pass Reciept')
@section('css')
   <style>
       footer{
           display: none;
       }
       html,body{
           background-color: white;
       }
       .main{
           display: flex;
           flex-flow:column;
           align-items: center;
       }
       h6{
           font-size: 15px;
       }
       .h6_14{
           font-size: 14px;
       }
       .h6_font_wt{
           font-weight: 400;
       }
       .box{
           display: flex;
           flex-flow:column;
           width: 100%;
           align-items: center;
           border:1px solid black;
       }
       .content-1{
           display: flex;
           flex-flow: column;
           align-items: center;
           justify-content: center;
           border-bottom: 1px solid black;
           width: 100%;
       }
       .content-1 p{
           width: 80%;
           text-align: center;
       }
       .content{
            display: flex;
           align-items: center;
           justify-content: space-around;
           width: 100%;
       }
       .date{
           display: flex;
           align-items: flex-start;
           justify-content: flex-end;
           width: 100%;
           flex-direction: row;
           padding-right: 20px;
       }
       .date-h6{
           margin-right: 27%;
       }
       .party-info{
           display: flex;
           width: 100%;
           border-bottom: 1px solid black;
           padding: 10px 0;
       }
       .party-info .right{
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 50%;
       }
       .half-left{
           padding-left: 15px;
           font-size: 14px;
           width: 30%;
       }
       .half-right{
           width: 60%;
       }
       .party-info .left{
            display: flex;
            justify-content: space-around;
            width: 50%;
       }
       table{
           width: 100%;
           margin-bottom: 30px;
       }
   </style>
@endsection
@section('header')
    @livewire('header')
@endsection
@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="main">
            <div class="box">
            @php
                 $unq = [];
             @endphp
             @foreach ($model as $item)
             @if (!in_array($item->related,$unq))
                <div class="content-1">
                    <h5 style="font-weight: 750;margin-top:20px;">DIGILIYO TECHNOLOGIES</h5>
                    <p>{{$company->company_detail}} <br> Contact/Email : {{$company->email}} {{$company->phone}}</p>
                    <div class="date">
                        <h6 class="date-h6" style="font-weight: 700;margin-bottom:15px;font-size:16px;">GATE IN PASS</h6>
                        <h6>Date : <span class="h6_font_wt"> {{date('d/m/Y h:i:s A',strtotime(now()))}}</span></h6>
                    </div>
                </div>
                <div class="party-info">
                    <div class="right">
                        <div class="half-left">
                            <h6>Gate Pass No </h6>
                            <h6>Transporter  </h6>
                            <h6>Consignee/CHA </h6>
                            <h6>Line  </h6>
                        </div>
                        <div class="half-right">
                            <h6 class="h6_font_wt">: &nbsp;&nbsp; {{$item->gate_pass_no}}</h6>
                            <h6 class="h6_font_wt">:&nbsp;&nbsp; {{$item->transpoter}}</h6>
                            <h6 class="h6_font_wt">: &nbsp;&nbsp;{{$item->cha}}</h6>
                            <h6 class="h6_font_wt">:&nbsp;&nbsp; {{$item->shipping_line}}</h6>
                        </div>
                    </div>
                    <div class="left">
                        <div class="half-left">
                            <h6>In Date </h6>
                            <h6>Vehicle No.  </h6>
                            <h6>Driver Name </h6>
                            <h6>Driver Contact  </h6>
                        </div>
                        <div class="half-right">
                            <h6 class="h6_font_wt">: {{date('d/m/Y h:i:s A',strtotime($item->in_date))}}</h6>
                            <h6 class="h6_font_wt">: {{$item->vehicle}}</h6>
                            <h6 class="h6_font_wt">: {{$item->driver_name}}</h6>
                            <h6 class="h6_font_wt">: {{$item->driver_contact}}</h6>
                        </div>
                    </div>
                </div>
                @php
                    $unq[] = $item->related;
                @endphp
             @endif
             @endforeach
                    <table>
                        <thead>
                            <tr style="border-bottom:1px solid black;padding:10px 0">
                                <th class="text-center" style="font-weight: 600;padding:5px 0">SR.No.</th>
                                <th class="text-center" style="font-weight: 600">Container No.</th>
                                <th class="text-center" style="font-weight: 600">Size</th>
                                <th class="text-center" style="font-weight: 600">Type</th>
                                <th class="text-center" style="font-weight: 600">ETY/LDD</th>
                                <th class="text-center" style="font-weight: 600">Location</th>
                                <th class="text-center" style="font-weight: 600">Source</th>
                                <th class="text-center" style="font-weight: 600">Is Damage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                        @endphp
                      @foreach ($model as $item)
                          <tr>
                              <td class="text-center" style="padding:5px 0">{{$i++}}</td>
                              <td class="text-center">{{$item->container_no}}</td>
                              <td class="text-center">{{$item->size}}</td>
                              <td class="text-center">{{$item->container_type}}</td>
                              <td class="text-center"></td>
                              <td class="text-center">{{$item->depot}}</td>
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                          </tr>
                      @endforeach
                        </tbody>
                    </table>
                <div class="content">
                    <h6 class="h6_14">For DIGILIYO TECHNOLOGIES</h6>
                    <h6 class="h6_14">Created By : {{ ucfirst(trans(Auth::user()->name)) }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection