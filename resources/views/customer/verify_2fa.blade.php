<!doctype html>
<html lang="en" data-pc-theme="{{$themMode}}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{'Login' . ' - ' . $siteTitle}}</title>
    <meta name="description" content="{{'Login' . ' - ' . $siteTitle}}"/>
    <meta name="keywords" content="{{'Login' . ' - ' . $siteTitle}}"/>
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
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5" style="max-width: 480px">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="{{route('home')}}"><img src="{{$siteLogo}}" alt="img" height="40" width="235" style="max-width: 100%" /></a>
                        </div>
                        <form id="2faForm">
                            <div class="saprator my-3">
                                <span>Verify 2FA Security</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="2faCode">Enter 6 Digit OTP</label>
                                <input type="text" class="form-control" id="2faCode" placeholder="Enter 2FA Code" />
                            </div>
                            <div class="d-grid mt-4">
                                <button id="2faBtn" class="btn btn-primary rounded w-100" type="submit">
                                    Verify
                                    <span id="2faLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            $('#2faForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    code: $('#2faCode').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.code) missingFields.push('Email');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('CODE NULL', message, 'danger', '/resource/high_priority-48.png', 5000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("verify_2fa_request") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#2faBtn').prop('disabled', true);
                        $('#2faLoader').show();
                    },
                    success: function (response) {
                        if (response.loginsuccess) {
                            $('#login').modal('hide');
                            $('#2faForm')[0].reset();
                            notifier.show('VERIFY SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                            location.reload();
                        } else {
                            notifier.show('VERIFY ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                            $('#2faBtn').prop('disabled', false);
                            $('#2faLoader').hide();
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
                        $('#2faBtn').prop('disabled', false);
                        $('#2faLoader').hide();
                    }
                });
            });
        });
    </script>
  </body>
</html>
