@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 mt-4">
            <form id="passUpdateForm">
                <div class="card pass-update-card">
                    <h5 class="card-header">Update Password</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="new_password">New Password</label>
                            <input type="text" id="new_password" class="form-control" placeholder="New Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <input type="text" id="confirm_password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="updatepassBtn" class="btn btn-primary rounded w-100" type="submit">
                            Update Password
                            <span id="updatepassLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('seo')
<title>{{'Update Your Password' . ' - ' . $siteTitle}}</title>
<meta name="description" content="Update Your Password"/>
<meta name="keywords" content="Update Your Password"/>
@endsection

@section('footer_script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Login Form Submission
        $('#passUpdateForm').on('submit', function (e) {
            e.preventDefault();
            const formData = {
                new_password: $('#new_password').val(),
                confirm_password: $('#confirm_password').val(),
                code: '{{$code}}',
                _token: '{{ csrf_token() }}'
            };
            let missingFields = [];
            if (!formData.new_password) missingFields.push('New password');
            if (!formData.confirm_password) missingFields.push('Confirm password');
            if (!formData.code) missingFields.push('Code');
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                notifier.show('PASSWORD ERROR', message, 'danger', '/resource/high_priority-48.png', 10000);
                return false;
            }

            if (formData.new_password !== formData.confirm_password) {
                notifier.show('PASSWORD ERROR', 'Passwords do not match!', 'danger', '/resource/high_priority-48.png', 10000);
                return false;
            }

            $.ajax({
                url: '{{ route("password_update_request") }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updatepassBtn').prop('disabled', true);
                    $('#updatepassLoader').show();
                },
                success: function (response) {
                    if (response.success) {
                        notifier.show('UPDATE SUCCESSFULLY!', response.message, 'success', '/resource/ok-48.png', 10000);
                        // window.location.href = response.redirect;
                        $('.pass-update-card').html(`
                            <div class="text-center p-5 js-added-content">
                                <img src="/resource/done.png" alt="OK" height="200" width="200" class="mb-4">
                                <div>${response.message}</div>
                                <div class="mt-4">
                                    <button class="btn btn-primary rounded" type="button" data-bs-toggle="modal" data-bs-target="#login">Login</button>
                                </div>
                            </div>
                        `)
                    } else {
                        notifier.show('UPDATE ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                        $('#updatepassBtn').prop('disabled', false);
                        $('#updatepassLoader').hide();
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
                    $('#updatepassBtn').prop('disabled', false);
                    $('#updatepassLoader').hide();
                }
            });
        });

    });
</script>
@endsection
