<!DOCTYPE html>
<html lang="en" data-pc-theme="{{ Auth::check() && Auth::user()->theme === 'dark' ? 'dark' : 'light' }}">
    <head>
        <title>Admin Dashboard - {{$siteTitle}}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="GSMTheme" />
        <link rel="icon" href="{{$siteFav}}" type="image/x-icon" />
        <link rel="stylesheet" href="{{asset('backend/fonts/inter/inter.css')}}" id="main-font-link" />
        <link rel="stylesheet" href="{{asset('backend/fonts/phosphor/duotone/style.css')}}" />
        <link rel="stylesheet" href="{{asset('backend/fonts/tabler-icons.min.css')}}" />
        <link rel="stylesheet" href="{{asset('backend/fonts/fontawesome.css')}}" />
        <link rel="stylesheet" href="{{asset('backend/css/style.css')}}" id="main-style-link" />
        <link rel="stylesheet" href="{{asset('backend/css/customstyle.css')}}" id="main-style-link" />
        <link rel="stylesheet" href="{{asset('backend/css/loader.css')}}" id="main-style-link" />
        <link rel="stylesheet" href="{{asset('backend/css/plugins/style.css')}}" id="main-style-link" />
        <link rel="stylesheet" href="{{asset('backend/css/style-preset.css')}}" />
        <link rel="stylesheet" href="{{asset('backend/css/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/css/simple-notify.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/css/notifier.css')}}">
        <link rel="stylesheet" href="{{asset('backend/css/choices.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/css/select2.min.css')}}">
        <script src="{{asset('backend/js/lottie-player.js')}}"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body
        data-pc-preset="{{ Auth::check() && Auth::user()->theme_color ? Auth::user()->theme_color : 'preset-8' }}"
        data-pc-sidebar-caption="true"
        data-pc-layout="vertical"
        data-pc-direction="ltr"
        data-pc-theme_contrast="">
        <div class="loader-bg" style="background: {{ Auth::check() && Auth::user()->theme === 'dark' ? '#131920' : '#f8f9fa' }};">
            <div class="loader-track"><div class="top-loader"><div class="loader-bar"></div></div></div>
        </div>
        <div class="top-loader" style="display:none;"><div class="loader-bar"></div></div>
        <x-admin-sidebar />
        <header class="pc-header" style="background: rgb(192 192 192 / 13%)">
            <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled gap-2">
                        <!-- ======= Menu collapse Icon ===== -->
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a href="#" class="pc-head-link ms-0 form-control border-grey-100" id="sidebar-hide" >
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a href="#" class="pc-head-link ms-0 form-control border-grey-100" id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item d-none d-md-inline-flex">
                            <form class="form-search">
                              <i class="search-icon">
                                <svg class="pc-icon">
                                  <use xlink:href="#custom-search-normal-1"></use>
                                </svg>
                              </i>
                              <input type="search" class="form-control" placeholder="Search" />
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- [Mobile Media Block end] -->
                <div class="ms-auto">
                    <ul class="list-unstyled">
                        <li class="dropdown pc-h-item">
                            <a href="{{route('home')}}" target="_blank" class="pc-head-link dropdown-toggle arrow-none me-0" href="#" role="button">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-home"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" href="#" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-setting-2"></use>
                                </svg>
                            </a>
                        </li>
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false" >
                                <img src="{{Auth::user()->logo ?? asset('resource/admin-logo.webp')}}" alt="user-image" class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-body">
                                    <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img src="{{Auth::user()->logo ?? asset('resource/admin-logo.webp')}}" alt="user-image" class="user-avtar wid-35" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{Auth::user()->name}}</h6>
                                                <span>{{Auth::user()->email}}</span>
                                            </div>
                                        </div>
                                        <hr class="border-secondary border-opacity-50" />
                                        <div class="d-grid mb-3">
                                            <a href="{{route('logout')}}" class="btn btn-primary">
                                                <svg class="pc-icon me-2">
                                                <use xlink:href="#custom-logout-1-outline"></use>
                                                </svg> Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="pc-container">
            <div class="pc-content">
                @yield('content')
            </div>
        </div>
        <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Admin Setting</h5>
                <button type="button" class="btn btn-icon btn-link-danger ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
            <div class="pct-body customizer-body">
                <div class="offcanvas-body py-0">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="pc-dark">
                                <h6 class="mb-1">Dashboard Theme Mode</h6>
                                <p class="text-muted text-sm">Choose light or dark mode</p>
                                <div class="row theme-color theme-layout">
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button
                                                class="preset-btn btn active theme-mode" data-value="true" data-bs-toggle="tooltip" title="Light">
                                                <svg class="pc-icon text-warning">
                                                <use xlink:href="#custom-sun-1"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-grid">
                                            <button class="preset-btn btn theme-mode" data-value="false" data-bs-toggle="tooltip" title="Dark">
                                                <svg class="pc-icon">
                                                <use xlink:href="#custom-moon"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h6 class="mb-1">Dashboard Theme Color</h6>
                            <p class="text-muted text-sm">Choose your primary theme color</p>
                            <div class="theme-color preset-color">
                              <a href="#" data-bs-toggle="tooltip" title="Blue" class="themeColor active" data-value="preset-1"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Indigo" class="themeColor" data-value="preset-2"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Purple" class="themeColor" data-value="preset-3"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Pink" class="themeColor" data-value="preset-4"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Red" class="themeColor" data-value="preset-5"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Orange" class="themeColor" data-value="preset-6"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Yellow" class="themeColor" data-value="preset-7"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Green" class="themeColor" data-value="preset-8"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Teal" class="themeColor" data-value="preset-9"><i class="ti ti-checks"></i></a>
                              <a href="#" data-bs-toggle="tooltip" title="Cyan" class="themeColor" data-value="preset-10"><i class="ti ti-checks"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <script src="{{asset('backend/js/plugins/apexcharts.min.js')}}"></script>
        <script src="{{asset('backend/js/pages/dashboard-default.js')}}"></script>
        <script src="{{asset('backend/js/plugins/popper.min.js')}}"></script>
        <script src="{{asset('backend/js/plugins/simplebar.min.js')}}"></script>
        <script src="{{asset('backend/js/plugins/bootstrap.min.js')}}"></script>
        <script src="{{asset('backend/js/plugins/feather.min.js')}}"></script>
        <script src="{{asset('backend/js/choices.min.js')}}"></script>
        <script src="{{asset('backend/js/fonts/custom-font.js')}}"></script>
        <script src="{{asset('backend/js/pcoded.js')}}"></script>
        <script src="{{asset('backend/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('backend/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('backend/js/simple-notify.min.js')}}"></script>
        <script src="{{asset('frontend/js/notifier.js')}}"></script>
        <script src="{{asset('backend/js/select2.min.js')}}"></script>
        @include('admin.include.theme')
        @yield('footer_script')
        <script>
            preset_change('{{ Auth::check() && Auth::user()->theme_color ? Auth::user()->theme_color : 'preset-8' }}');
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
            main_layout_change('vertical');
        </script>
    </body>
</html>
