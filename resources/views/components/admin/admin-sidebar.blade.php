<nav class="pc-sidebar border-0" style="background: white">
    <div class="navbar-wrapper">
        <div class="m-header" style="background:rgb(245 246 247); padding:0">
            <a href="{{route('admin')}}" class="b-brand text-primary w-100 text-center fw-bold text-uppercase" style="font-size: 20px; color: #5b6b79!important">
                <img src="{{$siteLogo}}" alt="" style="max-width: 230px; max-height:45px" id="main-logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">

                <li class="pc-item pc-hasmenu">
                    <a href="{{route('admin')}}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-tachometer-alt"> </i>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-element-plus"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Services List</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('server_service_list')}}">Server <span class="float-end" id="server-count">{{$serverServiceCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('credit_service_list')}}">Credit <span class="float-end" id="credit-count">{{$creditServiceCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('imei_service_list')}}">IMEI <span class="float-end" id="imei-count">{{$imeiServiceCount}}</span></a></li>
                        {{-- <li class="pc-item"><a class="pc-link" href="{{route('service_group')}}">Service Group </a></li> --}}
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-bag"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Order History</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('order_waiting_action')}}">Waiting Action <span class="float-end" id="waitingActionCount">{{$waitingActionCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('order_in_process')}}">In Process <span class="float-end" id="inProcessCount">{{$inProcessCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('order_success')}}">Success <span class="float-end" id="successCount">{{$successCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('order_rejected')}}">Rejected <span class="float-end" id="rejectedCount">{{$rejectedCount}}</span></a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="{{route('invoice_list')}}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-file-invoice"> </i>
                        </span>
                        <span class="pc-mtext">Invoice</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="{{route('digital_inventory')}}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fas fa-briefcase"> </i>
                        </span>
                        <span class="pc-mtext">Inventory</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-user"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">User</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('customer_list')}}">Coustomer <span class="float-end" id="coustomerCount">{{$coustomerCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('admin_user_list')}}">Site Admin <span class="float-end" id="userCount">{{$userCount}}</span></a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <i class="fas fa-compress"></i>
                        </span>
                        <span class="pc-mtext">Utilities</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('media_list')}}">Media Gallery</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('homepage_slider')}}">Home Page Slider</a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-refresh-2"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Automation</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('api_list')}}">API <span class="float-end" id="apiCount">{{$apiCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('build_in_api_list')}}">Build-in API <span class="float-end" id="buildinApiCount">{{$buildinApiCount}}</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('corn_list')}}">Corn Job List</a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-24-support"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Activity Log</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('api_log')}}">API Log</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('gateway_log')}}">Gateway Log</a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <div class="pc-link" style="cursor: pointer">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                            <use xlink:href="#custom-setting-2"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Settings</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                    ></div>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{route('admin_setting')}}">System Setting</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('currency_list')}}">Currency Config</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('payment_gateway')}}">Gateway Config</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('email_config')}}">Email Config</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{route('system_update')}}">System Update</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
