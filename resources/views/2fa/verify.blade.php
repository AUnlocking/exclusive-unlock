
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
                            <span>Google 2FA</span>
                        </div>
                        <form id="adminLoginForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="2fa_code" placeholder="6 Digit Code" />
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
                    code: $('#2fa_code').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.code) missingFields.push('6 digit code');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('OTP ERROR', message, 'danger', '/resource/high_priority-48.png', 5000);
                    return false;
                }
                $.ajax({
                    url: '{{ route('admin_verify_2fa_attempt') }}',
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
                            notifier.show('OTP ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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

            $('#2fa_code').focus();
            $('#2fa_code').on('input', function() {
                var value = $(this).val();
                value = value.replace(/[^0-9]/g, '');
                if (value.length > 6) {
                    value = value.substring(0, 6);
                }
                $(this).val(value);
            });








        });
    </script>
</body>
</html>
