@guest('customer')
    {{-- Login Modal --}}
    <div class="modal fade " id="login" tabindex="-1" aria-labelledby="login" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content login-content">
                <div class="modal-header " style="align-items:flex-start; padding: 20px 20px 0 20px">
                    <h5 class="modal-title" id="loginLabel">
                        <div></div>
                        <div>
                            <ul class="nav nav-tabs analytics-tab" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true" >
                                        LOGIN
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="true">
                                        REGISTER
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                        <form id="loginForm">
                            <div class="modal-body login-form px-4">
                                <div class="mb-3">
                                    <label for="login_email" class="form-label">Your Email</label>
                                    <div class="form-search">
                                        <i class="fas fa-envelope text-muted fs-4"></i>
                                        <input type="email" id="login_email" class="form-control" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="login_password" class="form-label">Your Password</label>
                                    <div class="form-search">
                                        <i class="fas fa-key text-muted fs-4"></i>
                                        <input type="password" id="login_password" class="form-control" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="mt-4 mb-2">
                                    <a href="#" class="forgot-btn">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button id="loginBtn" class="btn btn-primary rounded w-100" type="submit">
                                    Login
                                    <span id="loginLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab" tabindex="0">
                        <form id="registerForm">
                            <div class="modal-body login-form px-4">
                                <div class="mb-3">
                                    <label for="register_name" class="form-label">Enter Your Name</label>
                                    <div class="form-search">
                                        <i class="fas fa-user text-muted fs-4"></i>
                                        <input type="text" id="register_name" class="form-control" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="register_email" class="form-label">Enter Your Email</label>
                                    <div class="form-search">
                                        <i class="fas fa-envelope text-muted fs-4"></i>
                                        <input type="text" id="register_email" class="form-control" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="register_mobile" class="form-label">Enter Your Mobile</label>
                                    <div class="form-search">
                                        <i class="fas fa-mobile-alt text-muted fs-4"></i>
                                        <input type="text" id="register_mobile" class="form-control" placeholder="Mobile" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="register_password" class="form-label">Enter Your Password</label>
                                    <div class="form-search">
                                        <i class="fas fa-key text-muted fs-4"></i>
                                        <input type="password" id="register_password" class="form-control" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="register_currency" class="form-label">Enter Your Currency</label>
                                    <div class="form-search">
                                        <i class="fas fa-dollar-sign text-muted fs-4"></i>
                                        <select id="register_currency" class="form-control">
                                            <option value="">Choose Currency</option>
                                            @foreach ($currencyList as $currency)
                                                <option value="{{$currency->code}}">{{$currency->code . ' - ' . $currency->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button id="registerBtn" class="btn btn-primary rounded w-100" type="submit">
                                    Register
                                    <span id="registerLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-content otp-content" style="display: none">
                <div class="modal-header " style="align-items:flex-start; padding: 20px">
                    <h5 class="modal-title" id="otpLabel"><button type="button" class="btn btn-icon btn-light-primary back-to-login"><i class="fas fa-chevron-left"></i></button> <span class="ps-1 fs-6">Back</span></h5>
                </div>
                <form id="otpForm">
                    <div class="modal-body login-form px-4 py-4">
                        <div class="mb-3">
                            <label class="form-label" for="login_otp">Enter 6 Digit OTP</label>
                            <input type="text" class="form-control" id="login_otp" placeholder="OTP" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="otpBtn" class="btn btn-primary rounded w-100" type="submit">
                            Verify
                            <span id="otpLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-content register-otp-content" style="display: none">
                <form id="registerOtpForm">
                    <div class="modal-body login-form px-4 py-4">
                        <div class="register-opt-confirmation"></div>
                        <div class="mb-3">
                            <label class="form-label" for="register_otp">Enter Activation Code</label>
                            <input type="text" class="form-control" id="register_otp" placeholder="OTP" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="registerOtpBtn" class="btn btn-primary rounded w-100" type="submit">
                            Active Account
                            <span id="registerOtpLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-content pass-forgot-content" style="display: none">
                <div class="modal-header " style="align-items:flex-start; padding: 20px">
                    <h5 class="modal-title" id="otpLabel"><button type="button" class="btn btn-icon btn-light-primary back-to-login"><i class="fas fa-chevron-left"></i></button> <span class="ps-1 fs-6">Back</span></h5>
                </div>
                <form id="forgotForm">
                    <div class="modal-body login-form px-4 py-4">
                        <div class="mb-3">
                            <label class="form-label" for="forgot_email">Enter Your Email</label>
                            <input type="email" class="form-control" id="forgot_email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="forgotBtn" class="btn btn-primary rounded w-100" type="submit">
                            Reset Password
                            <span id="forgotLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-content reset-otp-content" style="display: none">
                <form id="verifyResetCodeForm">
                    <div class="modal-body login-form px-4 py-4">
                        <div class="reset-opt-confirmation"></div>
                        <div class="mb-3">
                            <label class="form-label" for="reset_otp">Enter 6 Digit Code</label>
                            <input type="text" class="form-control" id="reset_otp" placeholder="Code" />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="resetOtpBtn" class="btn btn-primary rounded w-100" type="submit">
                            Verify
                            <span id="resetOtpLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-content update-password-content" style="display: none">
                <div class="modal-header " style="align-items:flex-start; padding: 20px">
                    <h5 class="modal-title" id="otpLabel">Update Password</h5>
                </div>
                <form id="updatePasswordForm">
                    <div class="modal-body login-form px-4 py-4">
                        <div class="mb-3">
                            <label class="form-label" for="reset_new_pass">Enter New Password</label>
                            <input type="text" class="form-control" id="reset_new_pass" placeholder="New password" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="reset_confirm_pass">Confirm Password</label>
                            <input type="text" class="form-control" id="reset_confirm_pass" placeholder="Confirm password" />
                        </div>
                        <input type="hidden" id="reset_new_tocken">
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button id="updatePassBtn" class="btn btn-primary rounded w-100" type="submit">
                            Update Password
                            <span id="updatePassLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function () {
                $('#login').on('hide.bs.modal', function () {
                    $('#login-tab').addClass('active');
                    $('#register-tab').removeClass('active');
                    $('#login-tab-pane').addClass('show active');
                    $('#register-tab-pane').removeClass('show active');
                });
            });
            $(document).ready(function () {
                $('body').on('click', '.close-login-modal', function() {
                    $('#login').modal('hide');
                    location.reload();
                });
            });
            // Login Form Submission
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    email: $('#login_email').val(),
                    password: $('#login_password').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.email) missingFields.push('Email');
                if (!formData.password) missingFields.push('Password');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('INVALID CREDENTIAL!', message, 'danger', '/resource/high_priority-48.png', 5000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("login_request") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#loginBtn').prop('disabled', true);
                        $('#loginLoader').show();
                    },
                    success: function (response) {
                        if (response.login) {
                            notifier.show('LOGIN SUCCESS!', response.message, 'success', '/resource/ok-48.png', 10000);
                            window.location.reload();
                        } else if (response.checked) {
                            $('.login-content').hide();
                            $('.otp-content').show();
                            $('#login_otp').focus();
                            $('#loginBtn').prop('disabled', false);
                            $('#loginLoader').hide();
                        } else {
                            notifier.show('WRONG CREDENTIAL!', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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
                        notifier.show('ERROR!', errorMessage, 'danger', '/resource/high_priority-48.png', 10000);
                        $('#loginBtn').prop('disabled', false);
                        $('#loginLoader').hide();
                    }
                });
            });
            // OTP - Back To Login
            $('.back-to-login').on('click', function(){
                $('#otpForm')[0].reset();
                $('.otp-content').hide();
                $('.login-content').show();
                $('#login_email').focus();
            });
            // OTP Form Submission
            $('#otpForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    email: $('#login_email').val(),
                    password: $('#login_password').val(),
                    otp: $('#login_otp').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.email) missingFields.push('Email');
                if (!formData.password) missingFields.push('Password');
                if (!formData.otp) missingFields.push('OTP');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('OTP ERROR', message, 'danger', '/resource/high_priority-48.png', 5000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("login_attempt") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#otpBtn').prop('disabled', true);
                        $('#otpLoader').show();
                    },
                    success: function (response) {
                        if (response.login) {
                            notifier.show('LOGIN SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                            window.location.reload();
                        } else {
                            notifier.show('INCORRECT OTP!', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                            $('#otpBtn').prop('disabled', false);
                            $('#otpLoader').hide();
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
                        $('#otpBtn').prop('disabled', false);
                        $('#otpLoader').hide();
                    }
                });
            });
            // Register Form Submission
            $('#registerForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    name: $('#register_name').val(),
                    email: $('#register_email').val(),
                    mobile: $('#register_mobile').val(),
                    password: $('#register_password').val(),
                    currency: $('#register_currency').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.name) missingFields.push('Name');
                if (!formData.email) missingFields.push('Email');
                if (!formData.email) missingFields.push('Email');
                if (!formData.mobile) missingFields.push('Mobile');
                if (!formData.password) missingFields.push('Password');
                if (!formData.currency) missingFields.push('Currency');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('INVALID CREDENTIAL', message, 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("register_request") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#registerBtn').prop('disabled', true);
                        $('#registerLoader').show();
                    },
                    complete: function() {
                        $('#registerBtn').prop('disabled', false);
                        $('#registerLoader').hide();
                    },
                    success: function (response) {
                        if (response.success) {
                            notifier.show('CODE SENT', 'An activation code has been sent', 'success', '/resource/ok-48.png', 10000);
                            $('.login-content').hide();
                            $('.register-otp-content').show();
                            $('.register-opt-confirmation').html(`
                                <div class="text-center border-bottom pb-3 mb-3">
                                    <img src="/resource/mail-sent.png" alt="Mail Confirmation" style="max-width:100%">
                                    <p>An activation code has been sent to your email <b>${response.email}</b>. Please enter bellow.</p>
                                </div>
                            `);
                            $('#register_otp').focus();
                        } else {
                            notifier.show('REGISTER ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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
            });
            // Register Form Submission
            $('#registerOtpForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    code: $('#register_otp').val(),
                    email: $('#register_email').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.code) missingFields.push('Code');
                if (!formData.email) missingFields.push('Email');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('CODE REQUIRED!', message, 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("account_activation") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#registerOtpBtn').prop('disabled', true);
                        $('#registerOtpLoader').show();
                    },
                    success: function (response) {
                        if (response.success) {
                            notifier.show('REGISTER SUCCESS!', response.message, 'success', '/resource/ok-48.png', 10000);
                            window.location.reload();
                        } else {
                            notifier.show('ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                            $('#registerOtpBtn').prop('disabled', false);
                            $('#registerOtpLoader').hide();
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
                        $('#registerOtpBtn').prop('disabled', false);
                        $('#registerOtpLoader').hide();
                    }
                });
            });
            // Show Password Forget Form
            $('.forgot-btn').on('click', function(){
                $('.login-content').hide();
                $('.pass-forgot-content').show();
                $('#forgot_email').focus();
            });
            // Back to Login
            $('.back-to-login').on('click', function(){
                $('#forgotForm')[0].reset();
                $('.login-content').show();
                $('.pass-forgot-content').hide();
                $('#login_email').focus();
            });

            // Forget Password Form Submission
            $('#forgotForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    email: $('#forgot_email').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.email) missingFields.push('Email');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('EMAIL REQUIRED!', message, 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("password_reset_request") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#forgotBtn').prop('disabled', true);
                        $('#forgotLoader').show();
                    },
                    complete: function() {
                        $('#forgotBtn').prop('disabled', false);
                        $('#forgotLoader').hide();
                    },
                    success: function (response) {
                        if (response.success) {
                            notifier.show('CODE SENT!', response.message, 'success', '/resource/ok-48.png', 10000);
                            $('.pass-forgot-content').hide();
                            $('.reset-otp-content').show();
                            $('.reset-opt-confirmation').html(`
                                <div class="text-center border-bottom pb-3 mb-3">
                                    <img src="/resource/mail-sent.png" alt="Mail Confirmation" style="max-width:100%">
                                    <p>An password reset code has been sent to your email <b>${response.email}</b>. Please enter bellow.</p>
                                </div>
                            `);
                            $('#reset_otp').focus();
                        } else {
                            notifier.show('ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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
                        $('#registerOtpBtn').prop('disabled', false);
                        $('#registerOtpLoader').hide();
                    }
                });
            });
            // Password Reset Code Verify
            $('#verifyResetCodeForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    email: $('#forgot_email').val(),
                    code: $('#reset_otp').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.email) missingFields.push('Email');
                if (!formData.code) missingFields.push('Reset code');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('CODE REQUIRED!', message, 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("verify_password_reset_code") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#resetOtpBtn').prop('disabled', true);
                        $('#resetOtpLoader').show();
                    },
                    complete: function() {
                        $('#resetOtpBtn').prop('disabled', false);
                        $('#resetOtpLoader').hide();
                    },
                    success: function (response) {
                        if (response.success) {
                            notifier.show('VERIFIED!', response.message, 'success', '/resource/ok-48.png', 10000);
                            $('.reset-otp-content').hide();
                            $('.update-password-content').show();
                            $('#reset_new_tocken').val(response.resetcode);
                            $('#reset_new_pass').focus();
                        } else {
                            notifier.show('ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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
            });
            // Update password
            $('#updatePasswordForm').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    newPass : $('#reset_new_pass').val(),
                    conPass : $('#reset_confirm_pass').val(),
                    code: $('#reset_new_tocken').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.newPass) missingFields.push('New password');
                if (!formData.conPass) missingFields.push('Confirm password');
                if (!formData.code) missingFields.push('Reset code');
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    notifier.show('INVALID PASSWORD!', message, 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                if (formData.newPass !== formData.conPass) {
                    notifier.show('PASSWORDS DO NOT MATCH!', 'Enter the same password.', 'danger', '/resource/high_priority-48.png', 10000);
                    return false;
                }
                $.ajax({
                    url: '{{ route("password_update_request") }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#updatePassBtn').prop('disabled', true);
                        $('#updatePassLoader').show();
                    },
                    complete: function() {
                        $('#updatePassBtn').prop('disabled', false);
                        $('#updatePassLoader').hide();
                    },
                    success: function (response) {
                        if (response.success) {
                            notifier.show('RESET SUCCESS!', response.message, 'success', '/resource/ok-48.png', 10000);
                            $('.update-password-content').hide();
                            $('.login-content').show();
                            $('#login_email').focus();
                        } else {
                            notifier.show('ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
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
            });


            // Filter OTP Fields
            $('#login_otp, #register_otp, #reset_otp').on('input', function() {
                var value = $(this).val();
                value = value.replace(/[^0-9]/g, '');
                if (value.length > 6) {
                    value = value.substring(0, 6);
                }
                $(this).val(value);
            });
        });
    </script>

@endauth

