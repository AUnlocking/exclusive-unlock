@extends('layouts.admin')
@section('content')
<div class="lottie-container check-for-update" style="text-align: center;">
    <lottie-player
      src="{{ asset('resource/check-for-update.json') }}"
      background="transparent"
      speed="1.5"
      loop
      autoplay
      style="height: 400px;">
    </lottie-player>
    <div>
        Checking for updates...
    </div>
</div>
<div class="lottie-container up-to-dated" style="text-align: center; display:none">
    <lottie-player
      src="{{ asset('resource/rounded-success.json') }}"
      background="transparent"
      speed="0.05"
      loop
      autoplay
      style="height: 400px;">
    </lottie-player>
    <div>
        <h4>System is up to date ✅✅</h4>
        <div>Your system is currently running with version {{$currentVersion}}</div>
    </div>
</div>
<div class="system-update-card" style="display: none">
    <div class="card">
        <div class="card-body whats-new">
        </div>
    </div>
    <button class="btn btn-primary rounded start-download-btn"></button>
    <button class="btn btn-primary rounded downloading-loader" disabled style="display: none">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Downloading...
    </button>
    <button class="btn btn-primary rounded installing-loader" disabled style="display: none">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Installing...
    </button>
</div>
@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('check_system_update') }}',
            method: 'GET',
            success: function(response) {
                if(response.success){
                    if(response.currenVer < response.updateVer){
                        $('.check-for-update').hide();
                        $('.system-update-card').show();
                        $('.start-download-btn').html(`<i class="fas fa-cloud-download-alt"></i> Install Update ${response.updateVer}`);
                        $('.whats-new').html(`
                        <h4>Current version is ${response.currenVer}</h4>
                        ${response.whatsNew}
                        `);
                    }
                    else{
                        $('.check-for-update').hide();
                        $('.up-to-dated').show();
                    }
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error + "\nStatus: " + status);
            }
        });
        // Start download
        $('.start-download-btn').on('click', function(){
            $.ajax({
                url: '{{ route('download_system_update') }}',
                method: 'GET',
                beforeSend: function() {
                    $('.start-download-btn').hide();
                    $('.downloading-loader').show();
                },
                complete: function() {
                    $('.downloading-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('.start-download-btn').hide();
                        installUpdate();
                        // $('.install-update-btn').show();
                    }
                    else{
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('.start-download-btn').show();
                    alert("An error occurred: " + error + "\nStatus: " + status);
                }
            });
        });
        // Install Now
        function installUpdate(){
            $.ajax({
                url: '{{ route('install_update') }}',
                method: 'GET',
                beforeSend: function() {
                    $('.install-update-btn').hide();
                    $('.installing-loader').show();
                },
                complete: function() {
                    $('.installing-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        window.location.reload();
                    }
                    else{
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Hide the install update button on error
                    $('.install-update-btn').hide();
                    // Display the detailed error message
                    var errorMessage = "An error occurred: " + error + "\nStatus: " + status;
                    // Log the full error message to the console for debugging
                    console.error(errorMessage);
                    console.error("Response Text: ", xhr.responseText);
                    // Show the error message in an alert
                    alert(errorMessage);
                }
            });
        }
    })
</script>
@endsection
