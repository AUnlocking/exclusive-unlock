
<!doctype html>
<html lang="en" data-pc-theme="{{$themMode}}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{$siteTitle . ' - Payment Gateway'}}</title>
    <meta name="description" content="Payment Gateway"/>
    <meta name="keywords" content="Payment Gateway"/>
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
                <div class="card p-0" style="max-width: 850px">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 p-4">
                                <div class="border-bottom pb-4 mb-4">
                                    <a href="{{$gt_gateway->cancel_url}}"
                                        type="button"
                                        class="btn btn-icon btn-light-success">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    <span class="ps-2">Return</span>
                                </div>
                                <div class="text-center">
                                    <div class="mb-0 mb-lg-4">
                                        <div class="tesxt-muted">Pay {{$siteTitle}}</div>
                                        <div class="fs-2">${{ number_format($gt_gateway->gateway_amount, 2) }}</div>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="{{asset('resource/add_note.gif')}}" alt="" style="max-height: 450px; max-width:100%" class="border rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 p-4 custom-lg-left-border">
                                <div class="text-center">
                                    <img src="{{$gt_gateway->qrcode_url}}" alt="Binance Pay" height="200" width="200" style="max-width: 100%; max-height: 100%">
                                    <div class="my-3">Scan this QR Code by binance app then enter the following amount and note</div>
                                    <div class="border mx-auto my-3 py-2 fs-5 rounded">
                                        <div>USDT</div>
                                        <div class="fs-3 fw-bold">{{$gt_gateway->gateway_amount}}</div>
                                    </div>
                                    <div class="border mx-auto my-3 py-2 fs-5 rounded">
                                        <div style="color: #F0B90B">Add Note</div>
                                        <div class="fs-3 fw-bold">{{$gt_gateway->gateway_note}}</div>
                                    </div>
                                    <div class="rounded p-3 text-danger mt-3" style="border: 1px dashed red">
                                        Please ensure that you have entered the correct amount and included this number "<strong class="fs-5">{{$gt_gateway->gateway_note}}</strong>" in the NOTE. If any details are incorrect, the payment will not be verified.
                                    </div>
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 rounded paymentVerifyBtn">
                                            Verify Payment
                                            <span id="paymentVerifyLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    © {{$siteTitle}}. Powered by <a href="https://gsmtheme.com/" target="_blank">GSM Theme</a>
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
        $(document).ready(function() {
            $('.paymentVerifyBtn').on('click', function() {
                var slug = "{{$gt_gateway->checkout_url}}";
                $.ajax({
                    url: '/gt-gateway/verify/' + slug,
                    type: 'GET',
                    beforeSend: function () {
                        // Show loader
                        $('.paymentVerifyBtn').prop('disabled', true);
                        $('#paymentVerifyLoader').show();
                    },
                    success: function(response) {
                        if (response.success) {
                            notifier.show('PAYMENT SUCCESSFULLY!', response.message, 'success', '/resource/ok-48.png', 10000);
                            window.location.href = response.url;
                        } else {
                            $('.paymentVerifyBtn').prop('disabled', false);
                            $('#paymentVerifyLoader').hide();
                            notifier.show('UNSUCCESSFUL!', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.paymentVerifyBtn').prop('disabled', false);
                        $('#paymentVerifyLoader').hide();
                        notifier.show('UNSUCCESSFUL!', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            });
        });
    </script>

</body>
</html>
