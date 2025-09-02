@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 mt-4">
            <form id="resetForm">
                <div class="card pass-recover-card">
                    <h5 class="card-header">Password Reset</h5>
                    <div class="card-body">
                    <label class="form-label" for="reset_email">Enter your Email</label>
                     <input type="text" id="reset_email" class="form-control" placeholder="Email">
                    </div>
                    <div class="card-footer">
                        <button id="resetBtn" class="btn btn-primary rounded w-100" type="submit">
                            Reset Now
                            <span id="resetLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('seo')
<title>{{'Password Reset' . ' - ' . $siteTitle}}</title>
<meta name="description" content="Password Reset"/>
<meta name="keywords" content="Password Reset"/>
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
        $('#resetForm').on('submit', function (e) {
            e.preventDefault();
            const formData = {
                email: $('#reset_email').val(),
                _token: '{{ csrf_token() }}'
            };
            let missingFields = [];
            if (!formData.email) missingFields.push('Email');
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                notifier.show('EMAIL ERROR', message, 'danger', '/resource/high_priority-48.png', 10000);
                return false;
            }
            $.ajax({
                url: '{{ route("password_recover_request") }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#resetBtn').prop('disabled', true);
                    $('#resetLoader').show();
                },
                success: function (response) {
                    if (response.success) {
                        $('#resetForm')[0].reset();
                        $('#resetBtn').prop('disabled', false);
                        $('#resetLoader').hide();
                        notifier.show('RESET LINK SENT', response.message, 'success', '/resource/ok-48.png', 10000);

                        $('.pass-recover-card').html(`
                            <div class="text-center p-5 js-added-content">
                                <img src="/resource/mail-sent.png" alt="OK" height="200" width="200" class="mb-4">
                                <div>${response.message}</div>
                            </div>
                        `)


                    } else {
                        notifier.show('RESET ERROR', response.message || 'Something went wrong', 'danger', '/resource/high_priority-48.png', 10000);
                        $('#resetBtn').prop('disabled', false);
                        $('#resetLoader').hide();
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
                    $('#resetBtn').prop('disabled', false);
                    $('#resetLoader').hide();
                }
            });
        });

    });
</script>
@endsection
