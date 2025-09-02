@isset($themMode)
<!doctype html>
<html lang="en" data-pc-theme="{{$themMode}}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @yield('seo')
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="author" content="GSM Theme" />
    <link rel="icon" href="{{$siteFav}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" id="main-style-link" />
    <link rel="stylesheet" href="{{asset('frontend/css/customstyle.css')}}" id="main-style-link" />
    <link rel="stylesheet" href="{{asset('frontend/css/loader.css')}}" id="main-style-link" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/css/plugins/style.css')}}" id="main-style-link" />
    <link rel="stylesheet" href="{{asset('frontend/css/style-preset.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/landing.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/simple-notify.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/notifier.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/choices.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.dataTables.min.css')}}">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    @if($headerCode){!!$headerCode!!} @endif
</head>
<body
    data-pc-preset="{{$themeColor}}"
    data-pc-sidebar-caption="true"
    data-pc-direction="ltr"
    data-pc-theme_contrast=""
    data-pc-theme="{{$themMode}}"
    class="landing-page"
>
    <div class="loader-bg" style="background: {{ $themMode === 'dark' ? '#131920' : '#f8f9fa' }};">
        <div class="loader-track"><div class="top-loader"><div class="loader-bar"></div></div></div>
    </div>
    <div class="top-loader" style="display:none;"><div class="loader-bar"></div></div>
    <header class="d-block custom-header-height">
        <nav class="navbar navbar-expand-lg navbar-light default d-block py-0" style="z-index: 100">
            <div class="top-navbar py-2 d-none d-lg-block text-light @if($themMode == 'dark') bg-light-primary @else bg-primary @endif">
                <div class="container d-flex">
                    <div class="nav-item px-1 dropdown">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <div class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer"><i class="fas fa-phone"></i> Contact us</div>
                                <div class="dropdown-menu drp-technology nav-drp-tech-scrollble">
                                    @if ($siteWaUrl)
                                    <a class="dropdown-item gap-2" href="{{$siteWaUrl}}" target="_blank"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                                    @endif
                                    @if ($siteTeleUrl)
                                    <a class="dropdown-item gap-2" href="{{$siteTeleUrl}}" target="_blank"><i class="fab fa-telegram-plane"></i> Telegram</a>
                                    @endif
                                    @if ($siteFbUrl)
                                    <a class="dropdown-item gap-2" href="{{$siteFbUrl}}" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-collapse">
                        @if (Auth::guard('customer')->check())
                            <ul class="navbar-nav ms-auto">
                                @if ($themMode == 'dark')
                                <li class="nav-itemn"><a href="{{route('change_theme_mode')}}" class="text-reset"><i class="fas fa-moon fs-5"></i></a></li>
                                @else
                                <li class="nav-itemn"><a href="{{route('change_theme_mode')}}" class="text-reset"><i class="fas fa-sun fs-5"></i></a></li>
                                @endif
                                <li class="nav-itemn border-start border-light-primary p-l-15 m-l-15"><a class="text-reset" href="{{route('customer_add_balance')}}">Balance: {{round(Auth::guard('customer')->user()->balance, 2)}} {{App\Models\Currency::where('code', Auth::guard('customer')->user()->currency)->first()->icon}}</a></li>
                                <li class="nav-item border-start border-light-primary p-l-15 m-l-15 dropdown">
                                    <div class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer"><i class="fas fa-user"></i> {{Auth::guard('customer')->user()->name}} ({{Auth::guard('customer')->user()->role}})</div>
                                    <div class="dropdown-menu drp-technology nav-drp-tech-scrollble">
                                        <a class="dropdown-item gap-2" href="{{route('customer_order_history')}}"><i class="fas fa-shopping-cart"></i> My Order History</a>
                                        <a class="dropdown-item gap-2" href="{{route('customer_statement')}}"><i class="fas fa-dollar-sign"></i> My Statement</a>
                                        <a class="dropdown-item gap-2" href="{{route('customer_invoice')}}"><i class="fas fa-file-invoice"></i> My Invoice</a>
                                        <a class="dropdown-item gap-2" href="#" data-logout-url="{{route('customer_logout')}}" onclick="confirmLogout(this)">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <ul class="navbar-nav ms-auto ">
                                <li class="nav-item p-l-15 m-l-15 dropdown">
                                    <div class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-dollar-sign"></i> USD</div>
                                    <div class="dropdown-menu drp-technology nav-drp-tech-scrollble" style="min-width: auto">
                                        @foreach ($currencyList as $currency)
                                        <a class="dropdown-item gap-2" href="#">{{$currency->icon}} {{$currency->code}}</a>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container py-3 position-static">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{$siteLogo}}" alt="logo" style="max-width: 250px; max-height:40px" />
                </a>
                <button class="navbar-toggler rounded"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#menuOffcanvas"
                    aria-controls="menuOffcanvas"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    style="outline: none; box-shadow: none;"
                >
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item px-1 dropdown">
                            <button class="dropdown-toggle btn btn-light-primary border-primary rounded" data-bs-toggle="dropdown" href="#"><i  class="fas fa-lock-open"></i> Service List</button>
                            <div class="dropdown-menu drp-technology nav-drp-tech-scrollble">
                                <a class="dropdown-item gap-2" href="{{route('frontend_server_service')}}">
                                    <i class="fas fa-server"></i> Activation/Server
                                </a>
                                <a class="dropdown-item gap-2" href="{{route('frontend_credit_service')}}">
                                    <i class="fas fa-money-check-alt"></i> Tool's Credit Refill
                                </a>
                                <a class="dropdown-item gap-2" href="{{route('frontend_imei_service')}}">
                                    <i class="fas fa-lock-open"></i> IMEI/SN Service
                                </a>
                            </div>
                        </li>
                        @if (Auth::guard('customer')->check())
                        <li class="nav-item px-1">
                            <a href="{{route('customer_dashboard')}}" class="btn btn-light-primary border-primary rounded"><i class="fas fa-tachometer-alt"></i> My Dashboard</a>
                        </li>
                        @endif
                        @if (!Auth::guard('customer')->check())
                        <button class="btn btn-light-primary border-primary rounded" data-bs-toggle="modal" data-bs-target="#login" ><i class="fas fa-user"></i> <span style="padding-left: 5px">Login/Register</span></button>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')
    <div class="bg-white">
        <footer class="footer pt-0">
            <div class="border-top border-bottom footer-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                            <a class="navbar-brand" href="{{route('home')}}">
                                <img src="{{$siteLogo}}" alt="logo" style="max-width: 250px; max-height:40px" />
                            </a>
                            <div class="d-flex flex-wrap gap-2 my-4">
                                @if ($siteFbUrl)<a href="{{$siteFbUrl}}" target="_blank"><button type="button" class="btn btn-icon btn-primary"><i class="fab fa-facebook"></i></button></a>@endif
                                @if ($siteXUrl)<a href="{{$siteXUrl}}" target="_blank"><button type="button" class="btn btn-icon btn-primary"><i class="fab fa-twitter"></i></button></a> @endif
                                @if ($siteWaUrl)<a href="{{$siteWaUrl}}" target="_blank"><button type="button" class="btn btn-icon btn-primary"><i class="fab fa-whatsapp"></i></button></a> @endif
                                @if ($siteTeleUrl)<a href="{{$siteTeleUrl}}" target="_blank"><button type="button" class="btn btn-icon btn-primary"><i class="fab fa-telegram-plane"></i></button></a> @endif
                                @if ($siteYtUrl)<a href="{{$siteYtUrl}}" target="_blank"><button type="button" class="btn btn-icon btn-primary"><i class="fab fa-youtube"></i></button></a> @endif
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                                    <h5 class="mb-0 mb-lg-4 mt-4 mt-lg-0 text-uppercase fs-6">Site Link</h5>
                                    @if (Auth::guard('customer')->check())
                                    <ul class="list-unstyled footer-link">
                                        <li><a href="{{route('customer_order_history')}}">Order History</a></li>
                                        <li><a href="{{route('customer_statement')}}">My Statement</a></li>
                                        <li><a href="{{route('frontend_server_service')}}">Server Service</a></li>
                                        <li><a href="{{route('frontend_credit_service')}}">Credit Service</a></li>
                                        <li><a href="{{route('frontend_imei_service')}}">IMEI/SN Service</a></li>
                                    </ul>
                                    @else
                                    <ul class="list-unstyled footer-link">
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#login">Login/Register</a></li>
                                        <li><a href="{{route('password_recover')}}">Forgot Password</a></li>
                                        <li><a href="{{route('frontend_server_service')}}">Server Service</a></li>
                                        <li><a href="{{route('frontend_credit_service')}}">Credit Service</a></li>
                                        <li><a href="{{route('frontend_imei_service')}}">IMEI/SN Service</a></li>
                                    </ul>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-4 wow fadeInUp" data-wow-delay="0.8s">
                                    <h5 class="mb-0 mb-lg-4 mt-4 mt-lg-0 text-uppercase fs-6">Important Link</h5>
                                    <ul class="list-unstyled footer-link">
                                        <li><a href="#">Term & Condition</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Refund Policy</a></li>
                                        <li><a href="#">Cancellation Policy</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 wow fadeInUp" data-wow-delay="1s">
                                    <h5 class="mb-0 mb-lg-4 mt-4 mt-lg-0 mb-4 text-uppercase fs-6">Download App</h5>
                                    <div class="d-flex my-0 gap-2">
                                       <img src="{{asset('resource/android-app.webp')}}" alt="Android App" width="115" height="38" class="w-auto w-sm-50">
                                       <img src="{{asset('resource/ios-app.webp')}}" alt="iOS App" width="115" height="38" class="w-auto w-sm-50">
                                    </div>
                                    <div class="mb-3 mt-5">
                                        <h5 class="mb-0 mb-lg-4 mt-4 mt-lg-0 text-uppercase fs-6 mb-4">Newsletter</h5>
                                        <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Enter your email" />
                                        <button class="btn btn-primary" style="border-top-right-radius:8px;border-bottom-right-radius:8px;" type="button">Subscribe</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 my-2 text-center text-lg-start" data-wow-delay="0.4s">
                        <p class="mb-0">© {{$siteTitle}}. Powered by <a href="https://gsmtheme.com/" target="_blank">GSM Theme</a></p>
                    </div>
                    <div class="col-lg-6 my-2 text-center text-lg-end">
                        <ul class="list-inline footer-sos-link mb-0">
                            <li class="list-inline-item wow fadeInUp border-end pe-2" data-wow-delay="0.4s">
                                Pay with
                            </li>
                            <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                                <img src="{{asset('resource/binance_logo.png')}}" alt="" width="60" height="40" class="rounded">
                            </li>
                            <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                                <img src="{{asset('resource/bkash_logo.png')}}" alt="" width="60" height="40" class="rounded">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div
        class="offcanvas offcanvas-end"
        data-bs-scroll="true"
        tabindex="-1"
        id="menuOffcanvas"
        aria-labelledby="menuOffcanvasLabel"
        >
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-uppercase">{{$siteTitle}}</h5>
            <button type="button" class="btn-close text-reset text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if (Auth::guard('customer')->check())
            <h5 class="display-6 fs-5 border-bottom mb-2 pb-2">{{Auth::guard('customer')->user()->name}} ({{Auth::guard('customer')->user()->role}})</h5>
            <a class="text-reset border-bottom mb-2 pb-2 d-block" href="{{route('customer_order_history')}}">
                <i class="fas fa-shopping-cart" style="width: 25px"></i> My Order History <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a class="text-reset border-bottom mb-2 pb-2 d-block" href="{{route('customer_statement')}}">
                <i class="fas fa-dollar-sign" style="width: 25px"></i> My Statement <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a class="text-reset border-bottom mb-2 pb-2 d-block" href="{{route('customer_invoice')}}">
                <i class="fas fa-file-invoice" style="width: 25px"></i> My Invoice <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a class="text-reset border-bottom mb-4 pb-2 d-block" href="{{route('customer_dashboard')}}">
                <i class="fas fa-tachometer-alt" style="width: 25px"></i> My Dashboard <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            @endif
            <h5 class="display-6 fs-5 border-bottom mb-2 pb-2">SITE LINK</h5>
            <a class="text-reset border-bottom mb-2 pb-2 d-block" href="{{route('frontend_server_service')}}">
                <i class="fas fa-server" style="width: 25px"></i> Activation/Server <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a class="text-reset border-bottom mb-2 pb-2 d-block" href="{{route('frontend_credit_service')}}">
                <i class="fas fa-money-check-alt" style="width: 25px"></i> Tool's Credit Refill <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a class="text-reset border-bottom mb-4 pb-2 d-block" href="{{route('frontend_imei_service')}}">
                <i class="fas fa-lock-open" style="width: 25px"></i> IMEI/SN Service <span class="float-end text-muted"><i class="fas fa-arrow-right"></i></span>
            </a>
            @if (Auth::guard('customer')->check())
            <a href="#" class="btn btn-light-danger border-danger rounded w-100" data-logout-url="{{route('customer_logout')}}" onclick="confirmLogout(this)" ><i class="fas fa-sign-out-alt"></i> <span style="padding-left: 5px">Logout</span></a>
            @else
            <button class="btn btn-light-primary border-primary rounded w-100" data-bs-toggle="modal" data-bs-target="#login" ><i class="fas fa-user"></i> <span style="padding-left: 5px">Login/Register</span></button>
            @endif
        </div>
    </div>

    <style>body.modal-open {overflow: visible !important; padding-right: 0 !important}</style>
    <!-- Required Js -->
    <script src="{{asset('frontend/js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/popper.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/simplebar.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/pcoded.js')}}"></script>
    <script src="{{asset('frontend/js/simple-notify.min.js')}}"></script>
    <script src="{{asset('frontend/js/notifier.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.dataTables.min.js')}}"></script>
    @yield('footer_script')
    <script>
        layout_change('{{$themMode}}');
    </script>
    <script>
        layout_theme_contrast_change('false');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_caption_change('true');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change('{{$themeColor}}');
    </script>
    <script>
        function confirmLogout(element) {
            var logoutUrl = $(element).data('logout-url');
            if (confirm("Are you sure to logout?")) {window.location.href = logoutUrl;}
        }
    </script>
    @include('frontend.include.login')
</body>
</html>
@else
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GSM Theme Installer</title>
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" id="main-style-link" />
</head>
<body>
    <div class="modal fade modal-animate" id="installDB" tabindex="-1" aria-labelledby="addNewAPI" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('install_db')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewCustomerLabel">Install Database</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row my-3"  style="margin: 10px 0">
                            <label for="db_name" class="col-sm-5 col-form-label">Database Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="db_name" placeholder="Database Name" name="DB_DATABASE" />
                            </div>
                        </div>
                        <div class="row my-3" style="margin: 10px 0">
                            <label for="db_user" class="col-sm-5 col-form-label">Database Username</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="db_user" placeholder="Database Username" name="DB_USERNAME" />
                            </div>
                        </div>

                        <div class="row my-3" style="margin: 10px 0">
                            <label for="db_user_pass" class="col-sm-5 col-form-label">Database Password</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="db_user_pass" placeholder="Database Password" name="DB_PASSWORD" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="new-update-button" type="submit">
                            <i class="fas fa-check-circle"></i> Install
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('frontend/js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Show the modal when the page loads
            $('#installDB').modal('show');
        });
    </script>
</body>
</html>
@endisset




