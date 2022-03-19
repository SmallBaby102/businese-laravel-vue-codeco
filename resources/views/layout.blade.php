<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@yield('title')</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        {{-- <!-- jvectormap -->
        <link href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet">
        <link href="{{asset('assets/plugins/fullcalendar/vanillaCalendar.css')}}" rel="stylesheet" type="text/css"  />
        
        <link href="{{asset('assets/plugins/morris/morris.css')}}" rel="stylesheet"> --}}
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
        @yield('css')
        @livewireStyles
        @livewireScripts
    </head>


    <body>

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        @yield('header')
       
        @yield('content')
        
        <!-- end wrapper -->


        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        © Copyright 2022 <a style='color: #283179;font-weight:600;' href='#' target='_BLANK'>DIGILIYO TECHNOLOGIES</a> All right reserved | Manage & Design by <a style='color: #283179;font-weight:600;' href='https://digiliyo.com/' target='_BLANK'>Digiliyo Technologies</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- jQuery  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>
        <!-- Sweet-Alert  -->
        <script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>  
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        @yield('js')
    </body>
</html>