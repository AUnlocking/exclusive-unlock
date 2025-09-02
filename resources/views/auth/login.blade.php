
<!doctype html>
<html lang="en" data-pc-theme="{{$themMode}}">
<head>
    <title>Admin Login | {{$siteTitle}}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-sidecontent">
            <img src="{{asset('resource/img-auth-sideimg.jpg')}}" alt="images" class="img-fluid img-auth-side" />
            </div>
            <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{route('home')}}"><img src="{{$siteLogo}}" alt="img"  style="max-width: 100%" /></a>
                    </div>
                    <div class="saprator my-4">
                        <span>Admin Login</span>
                    </div>
                    <form id="adminLoginForm">
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Email Address" />
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" />
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                            <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="" />
                            <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                            </div>
                            <h6 class="text-secondary f-w-400 mb-0">
                            {{-- <a href="#"> Forgot Password? </a> --}}
                            </h6>
                        </div>
                        <div class="d-grid mt-4">
                            <button id="loginBtn" class="btn btn-primary rounded w-100" type="submit">
                                Login
                                <span id="loginLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 start-0 p-3 text-muted">
        <small>©{{ now()->year }}. POWERED BY GSM THEME</small>
    </div>

    <!-- Required Js -->
    <script src="{{asset('frontend/js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/popper.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/simplebar.min.js')}}"></script>
    <script src="{{asset('frontend/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/pcoded.js')}}"></script>
    <script src="{{asset('frontend/js/simple-notify.min.js')}}"></script>
    <script src="{{asset('frontend/js/notifier.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.dataTables.min.js')}}"></script>
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Login Form Submission
            $('#adminLoginForm').on('submit', function (e) {
            e.preventDefault();
            const formData = {
                email: $('#email').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}'
            };
            let missingFields = [];
            if (!formData.email) missingFields.push('Email');
            if (!formData.password) missingFields.push('Password');
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                notifier.show('CREDENTIAL ERROR', message, 'danger', '/resource/high_priority-48.png', 5000);
                return false;
            }
            $.ajax({
                url: '{{ route('admin_login_request') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#loginBtn').prop('disabled', true);
                    $('#loginLoader').show();
                },
                success: function (response) {
                    if (response.success) {
                        window.location.href = "{{ route('admin') }}";
                    } else {
                        notifier.show('LOGIN ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                        $('#loginBtn').prop('disabled', false);
                        $('#loginLoader').hide();
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    notifier.show('ERROR', errorMessage, 'danger', '/resource/high_priority-48.png', 10000);
                    $('#loginBtn').prop('disabled', false);
                    $('#loginLoader').hide();
                }
            });
        });








        });
    </script>
</body>
</html>
