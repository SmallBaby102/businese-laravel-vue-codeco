<header id="topnav">
   <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu text-right">
                    <li style="float:left;" class="has-submenu ">
                        <a href="/dashboard" style="font-size:20px; margin-top:4px;">DIGILIYO TECHNOLOGIES</a>
                    </li>
                    <li class="has-submenu ">
                        <a href="javascript:;"><i class="ion-cube"></i>Master</a>
                        <ul class="submenu">
                            <li><a href="{{route('company.index')}}">Company Profile</a></li>
                            <li><a href="{{route('status-master.index')}}">status Master</a></li>
                            <li><a href="{{route('line-master.index')}}">Line Master</a></li>
                            <li><a href="{{route('container-type.index')}}">Container Type</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu ">
                        <a href="javascript:;"><i class="ion-compose"></i>Daily Entry</a>
                        <ul class="submenu">
                            <li><a href="{{route('out_container')}}">In & Out Details</a></li>
                            <li><a href="{{route('gate-pass.index')}}">Gate Pass</a></li>
                            <li><a href="{{route('estimate_data_report')}}">Estimate Data Report</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu ">
                        <a href="javascript:;"><i class="ion-clipboard"></i>Daily Report</a>
                        <ul class="submenu">
                            <li><a href="{{route('inventory-report.index')}}">Inventory Report</a></li>
                            <li><a href="{{route('container_register')}}">Container Register</a></li>
                            <li><a href="{{route('total_in_out_movement')}}">Total In & Out Movement</a></li>
                            <li><a href="{{route('edi')}}">Edi Report</a></li>
                            <li><a href="{{route('depot_stock_report')}}">Depot Stock Report</a></li>
                            <li><a href="{{route('ial_report')}}">IAL Report</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu ">
                        <a href="javascript:;"><i class="ion-gear-a"></i>System Setting</a>
                        <ul class="submenu">
                            <li><a href="{{route('estimate_data_import')}}">Estimate Data Import</a></li>
                            <li><a href="{{route('excel_update_view')}}">Excel Update</a></li>
                            <li><a href="{{route('upload-ial-file.index')}}">IAL Upload</a></li>
                            <li><a href="{{route('offhire')}}">Offhire</a></li>
                            @if (Auth::user()->type == 'super_admin')
                            <li><a href="{{route('bulk_upload.index')}}">Bulk Upload</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="has-submenu ">
                        <a href="javascript:;"><i class="mdi mdi-account"></i>User Setting</a>
                        <ul class="submenu">
                            <li><a href="{{url('user/profile')}}">Profile</a></li>
                            @if (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin')
                            <li><a href="{{route('user.create')}}">Create User</a></li>
                            @endif
                            <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Logout</a></li>
                            <form action="{{route('logout')}}" id="form-logout" method="post">
                                @csrf
                                
                            </form>
                        </ul>
                    </li>

                </ul>
                
                
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>