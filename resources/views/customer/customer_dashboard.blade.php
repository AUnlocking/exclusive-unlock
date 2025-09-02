@extends('layouts.frontend')
@section('content')
<div class="container">

    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
        </ol>
    </nav>

    <div class="row">
        <a class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-secondary">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Waiting Action</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{$waitingAction}} <span class="fs-6">Order</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">In Process</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{$inProcess}} <span class="fs-6">Order</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Success</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{$Success}} <span class="fs-6">Order</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-danger">
                                <i class="fas fa-ban"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Rejected</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">{{$Rejected}} <span class="fs-6">Order</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-xl-center">
                    <div>Available balance</div>
                    @if ($Customer->balance < 0)
                    <div class="fs-4 text-red-500">{{round($Customer->balance, 2).' '.$currency->icon.' ('.$currency->code .')'}}</div>
                    @else
                    <div class="fs-4">{{round($Customer->balance, 2).' '.$currency->icon.' ('.$currency->code .')'}}</div>
                    @endif
                </div>
                <hr class="d-block d-xl-none mt-4 text-muted">
                <div class="col-md-4 custom-xl-left-border text-xl-center  mt-xl-0 mt-4">
                    <div>Locked Amount</div>
                    <div class="fs-4">{{round($lockedAmount, 2) .' '.$currency->icon}}</div>
                </div>
                <hr class="d-block d-xl-none mt-4 text-muted">
                <div class="col-md-4 custom-xl-left-border text-xl-center mt-xl-0 mt-4">
                    <div>Total Receipts</div>
                    <div class="fs-4">{{round($totalReceipts, 2) .' '.$currency->icon}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
          <div class="row g-3 text-center">
            <div class="col-md-3">
                <a href="{{route('customer_add_balance')}}" class="card mb-0">
                    <div class="card-body py-4 px-2 ">
                        <i class="fas fa-plus fs-1 text-muted"></i>
                    <h6 class="mb-0 mt-3 text-muted">Add Balance</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('customer_invoice')}}" class="card mb-0">
                    <div class="card-body py-4 px-2">
                        <i class="fas fa-file-invoice fs-1 text-muted"></i>
                    <h6 class="mb-0 mt-3 text-muted">My Invoice</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('customer_statement')}}" class="card mb-0">
                    <div class="card-body py-4 px-2">
                        <i class="fas fa-dollar-sign fs-1 text-muted"></i>
                    <h6 class="mb-0 mt-3 text-muted">My Statement</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('customer_order_history')}}" class="card mb-0">
                    <div class="card-body py-4 px-2">
                        <i class="fas fa-shopping-cart fs-1 text-muted"></i>
                    <h6 class="mb-0 mt-3 text-muted">My Order History</h6>
                    </div>
                </a>
            </div>
          </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 pt-2">
                <ul class="nav nav-tabs analytics-tab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true" >
                            <i class="fas fa-user"></i> <span class="px-2">Profile</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-tab-pane" type="button" role="tab" aria-controls="security-tab-pane" aria-selected="true">
                            <i class="fas fa-user-lock"></i> <span class="px-2">Security</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="api-tab" data-bs-toggle="tab" data-bs-target="#api-tab-pane" type="button" role="tab" aria-controls="api-tab-pane" aria-selected="true">
                            <i class="fas fa-sync-alt"></i> <span class="px-2">API Access</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body px-4 py-0">
                <div class="row">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="card-body px-0">
                                <div class="mb-3">
                                    <label for="dash_email" class="form-label">Email</label>
                                    <input readonly class="form-control bg-gray-200" id="dash_email" value="{{$Customer->email}}">
                                </div>
                                <div class="mb-3">
                                    <label for="dash_currency" class="form-label">Currency</label>
                                    <input readonly class="form-control bg-gray-200" id="dash_currency" value="{{$Customer->currency}}">
                                </div>
                                <div class="mb-3">
                                    <label for="dash_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="dash_name" value="{{$Customer->name}}">
                                </div>
                                <div class="mb-3">
                                    <label for="dash_mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="dash_mobile" value="{{$Customer->mobile}}">
                                </div>
                            </div>
                            <div class="card-footer px-0 profile-update-footer">
                                <button type="button" class="btn btn-primary rounded dashProfileUpdate"><i class="fas fa-check-circle"></i> Update Profile</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="security-tab-pane" role="tabpanel" aria-labelledby="security-tab" tabindex="0">
                            <div class="card-body px-0">
                                <div class="row mb-3 align-items-center border-bottom pb-3">
                                    <label for="" class="col-8 col-form-label col-form-label">Enable 2FA - Eamil OTP</label>
                                    <div class="col-4">
                                        <div class="form-check form-switch custom-switch-v1 float-end">
                                            <input class="form-check-input input-primary" type="checkbox" id="2faEmail" style="padding:15px 30px; cursor: pointer;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="" class="col-8 col-form-label col-form-label">Enable 2FA - Mobile App</label>
                                    <div class="col-4">
                                        <div class="form-check form-switch custom-switch-v1 float-end">
                                            <input class="form-check-input input-primary" type="checkbox" id="2faAuth" style="padding:15px 30px; cursor: pointer;">
                                        </div>
                                    </div>
                                </div>
                                <div class="security-section">
                                    <div class="2fa-qrcode">
                                        <img id="qrCodeUrl" alt="QR Code">
                                        <form id="verifyOtpForm">
                                            <div class="mt-3" style="max-width:200px">
                                                <input type="text" id="2fa-otp" class="form-control" placeholder="Enter 6 Digit OTP">
                                            </div>
                                            <div class="mt-3" style="max-width:200px">
                                                <button id="verifyOtpBtn" class="btn btn-primary rounded w-100" type="submit">
                                                    Enable 2FA
                                                    <span id="verifyOtpBtnLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="api-tab-pane" role="tabpanel" aria-labelledby="api-tab" tabindex="0">
                            <div class="card-body px-0">
                                <div class="row mb-3 align-items-center border-bottom pb-3">
                                    <label for="" class="col-8 col-form-label col-form-label">API Access</label>
                                    <div class="col-4">
                                        <div class="form-check form-switch custom-switch-v1 float-end">
                                            <input class="form-check-input input-primary" type="checkbox" id="apiAccess" style="padding:15px 30px; cursor: pointer;" @if ($Customer->api_allow == 'on') checked @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="api-section">
                                    <div class="mb-3">
                                        <label for="apiURL" class="form-label">Api URL</label>
                                        <div class="input-group">
                                            <input readonly class="form-control" id="apiURL" value="{{$siteURL.'/public'}}" />
                                            <button class="btn btn-outline-secondary rounded-end" type="button" onclick="copyToClipboard('apiURL')">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apiUserName" class="form-label">Username</label>
                                        <div class="input-group">
                                            <input readonly class="form-control" id="apiUserName" value="{{$Customer->email}}" />
                                            <button class="btn btn-outline-secondary rounded-end" type="button" onclick="copyToClipboard('apiUserName')">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apiAccessKey" class="form-label">API Access Key</label>
                                        <div class="input-group">
                                            <input readonly class="form-control" id="apiAccessKey" value="{{$Customer->api_key}}" />
                                            <button class="btn btn-outline-secondary rounded-end" type="button" onclick="copyToClipboard('apiAccessKey')">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apiIP" class="form-label">Allow IP</label>
                                        <div class="input-group">
                                          <input readonly class="form-control" id="apiIP" value="{{$Customer->api_ip}}" />
                                          <button class="btn btn-outline-secondary rounded-end resetApiIP" type="button"> <i class="fas fa-unlink"></i> Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer px-0 changeAccessKeyFooter">
                                <button type="button" class="btn btn-primary rounded changeAccessKey"><i class="fas fa-sync-alt"></i> Change Access Key</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('seo')
<title>{{'My Dashboard - ' . $siteTitle}}</title>
<meta name="description" content="My Dashboard"/>
<meta name="keywords" content="My Dashboard"/>
@endsection
@section('footer_script')
<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value).then(function() {
            notifier.show('Copied!', copyText.value, 'success', '/resource/ok-48.png', 10000);
        }).catch(function() {
            alert("Failed to copy.");
        });
    }
</script>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Fetch Customer Details
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('fetch_auth_customer') }}',
                method: 'GET',
                beforeSend: function () {
                    $('.top-loader').show();
                },
                complete: function () {
                    $('.top-loader').hide();
                },
                success: function (response) {
                    if(response.success){
                        $('#2faEmail').prop('checked', response.customer.otp_enabled);
                        $('#2faAuth').prop('checked', response.customer.google2fa_enabled);
                        if (response.customer.google2fa_enabled) {
                            $('#2faAuth').prop('disabled', false);
                        } else {
                            $('#2faAuth').prop('disabled', true);
                        }
                        if(response.qrCode){
                            const svgData = encodeURIComponent(response.qrCode);
                            const svgUrl = 'data:image/svg+xml;charset=utf-8,' + svgData;
                            $('#qrCodeUrl').attr('src', svgUrl);
                        }
                        else{
                            $('.2fa-qrcode').hide();
                        }
                    }
                    else{
                        notifier.show('ERROR', 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function (xhr, status, error) {
                    notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
            // Form Submit
            $('#verifyOtpForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    twoFaOtp: $('#2fa-otp').val(),
                    _token: '{{ csrf_token() }}',
                };
                let missingFields = [];
                // Validate OTP field
                if (!formData.twoFaOtp) {
                    missingFields.push('6 Digit OTP');
                }
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('OTP ERROR', message, 'danger', '/resource/high_priority-48.png', 5000);
                    return false;
                }
                // Start the AJAX request
                $.ajax({
                    url: '{{ route("customer_2fa_verify") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function () {
                        // Show loader
                        $('.top-loader').show();
                        $('#verifyOtpBtn').prop('disabled', true);
                        $('#verifyOtpBtnLoader').show();
                    },
                    complete: function () {
                        // Hide loader
                        $('.top-loader').hide();
                        $('#verifyOtpBtn').prop('disabled', false);
                        $('#verifyOtpBtnLoader').hide();
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.2fa-qrcode').hide();
                            $('#2faAuth').prop('checked', true);
                            $('#2faAuth').prop('disabled', false);
                            $('#verifyOtpForm')[0].reset();
                            notifier.show('SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                        } else {
                            notifier.show('OTP ERROR', response.message || 'An error occurred', 'danger', '/resource/high_priority-48.png', 5000);
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
                    }
                });
                return false;
            });
            // Remove 2FA For customer
            $('#2faAuth').on('change', function() {
                var checkbox = $(this);
                if (!checkbox.prop('checked')) {
                    var userConfirmed = confirm("Are you sure you to turn off 2FA?");
                    if (userConfirmed) {
                        $.ajax({
                            url: '{{route('customer_2fa_remove')}}',
                            method: 'GET',
                            beforeSend: function() {
                                $('.top-loader').show();
                            },
                            complete: function() {
                                $('.top-loader').hide();
                            },
                            success: function(response) {
                                if (response.success) {
                                    notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                                    checkbox.prop('disabled', true);
                                    if(response.qrCode){
                                        const svgData = encodeURIComponent(response.qrCode);
                                        const svgUrl = 'data:image/svg+xml;charset=utf-8,' + svgData;
                                        $('#qrCodeUrl').attr('src', svgUrl);
                                        $('.2fa-qrcode').show();
                                    }
                                } else {
                                    checkbox.prop('checked', true);
                                    notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                }
                            },
                            error: function(xhr, status, error) {
                                checkbox.prop('checked', true);
                                notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                            }
                        });
                    } else {
                        checkbox.prop('checked', true);
                    }
                }
            });
            // Update Email 2FA
            $('#2faEmail').on('change', function() {
                var checkbox = $(this);
                if (!checkbox.prop('checked')) {
                    var confirmDisable = confirm("Are you sure to disable email 2FA?");
                    if (!confirmDisable) {
                        checkbox.prop('checked', true);
                        return;
                    }
                }
                $.ajax({
                    url: '{{ route('update_email_2fa') }}',
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                        } else {
                            notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            });

        });

        // Filter OTP Fields
        $('#2fa-otp').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 6) {
                this.value = this.value.substring(0, 6);
            }
        });

        let apiAccess = '{{$Customer->api_allow}}'
        apiAccessToggle(apiAccess);
        $('#dash_mobile').on('input', function(event) {
            $('#dash_mobile').on('input', function() {
                var value = $(this).val();
                value = value.replace(/[^0-9+]/g, '');
                if (value.length > 15) {
                    value = value.substring(0, 15);
                }
                $(this).val(value);
            });
        });
        function apiAccessToggle(apiAccess){
            if(apiAccess == ''){
                $('.api-section').hide();
                $('.changeAccessKeyFooter').hide();
                $('.api-access-hr').hide();
            }
            else{
                $('.api-section').show();
                $('.changeAccessKeyFooter').show();
                $('.api-access-hr').show();
            }
        }
        // Update profile
        $('.dashProfileUpdate').off('click').on('click', function () {
            const formData = {
                name: $('#dash_name').val(),
                mobile: $('#dash_mobile').val(),
                _token: '{{ csrf_token() }}',
            };
            const loadingButton = `
                <button class="btn btn-primary dash-profile-updating-loader rounded" type="button">
                    <span class="spinner-border spinner-border-sm" role="status"></span> Updating....
                </button>
            `;
            let missingFields = [];
            if (!formData.name) {
                missingFields.push('Name');
            }
            if (!formData.mobile) {
                missingFields.push('Mobile');
            }
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                notifier.show('ERROR', message, 'danger', '/resource/high_priority-48.png', 10000);
                return false;
            }
            $.ajax({
                url: '{{ route('customer_update_das_profile') }}',
                method: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.top-loader').show();
                    $('.profile-update-footer').append(loadingButton);
                    $('.dashProfileUpdate').hide();
                },
                complete: function () {
                    $('.top-loader').hide();
                    $('.dash-profile-updating-loader').remove();
                    $('.dashProfileUpdate').show();
                },
                success: function (response) {
                    if(response.success){
                        notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                    }
                    else{
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function (xhr, status, error) {
                    notifier.show('ERROR', xhr.responseJSON.message, 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        });
        // Change Access Key
        $('.changeAccessKey').on('click', function () {
            if (!confirm('Are you sure to change api access key?')) {
                return;
            }
            const loadingButton = `
                <button class="btn btn-primary dash-accesskey-updating-loader rounded" type="button">
                    <span class="spinner-border spinner-border-sm" role="status"></span> Generating new key...
                </button>
            `;
            $.ajax({
                url: '{{ route("customer_generate_access_key") }}',
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                beforeSend: function () {
                    $('.top-loader').show();
                    $('.changeAccessKeyFooter').append(loadingButton);
                    $('.changeAccessKey').hide();
                },
                complete: function () {
                    $('.top-loader').hide();
                    $('.dash-accesskey-updating-loader').remove();
                    $('.changeAccessKey').show();
                },
                success: function (response) {
                    if(response.success){
                        notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                        $('#apiAccessKey').val(response.api_key);
                    }
                    else{
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function (xhr, status, error) {
                    notifier.show('ERROR', xhr.responseJSON.message, 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        });
        // Update API Status
        $('#apiAccess').on('change', function() {
            let isChecked = $(this).is(':checked');
            let apiAccess = isChecked ? 'on' : '';
            apiAccessToggle(apiAccess);
            $.ajax({
                url: '{{ route("customer_update_api_status") }}',
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    api_access: apiAccess
                },
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function () {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                    }
                    else{
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', xhr.responseJSON.message, 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        });
        $('.resetApiIP').on('click', function() {
            if (confirm('Are you sure to reset the API IP?')) {
                $.ajax({
                    url: '{{ route("customer_reset_api_ip") }}',
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function () {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if(response.success){
                            $('#apiIP').val('');
                            notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                        }
                        else{
                            notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        notifier.show('ERROR', xhr.responseJSON.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            }
        });

    });
</script>
@endsection
