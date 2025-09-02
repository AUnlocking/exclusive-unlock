@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="d-block d-md-flex">
        <div class="setting-m-menu" id="menu">
            <button type="button" data-section="general" class="active btn rounded-0"><span>General</span></button>
            <button type="button" data-section="logo" class="btn rounded-0"><span>Site Logo</span></button>
            <button type="button" data-section="theme" class="btn rounded-0"><span>Site Theme</span></button>
            <button type="button" data-section="social" class="btn rounded-0"><span>Social Media</span></button>
            <button type="button" data-section="headercode" class="btn rounded-0"><span>Header Code</span></button>
            <button type="button" data-section="system" class="btn rounded-0"><span>System</span></button>
            <button type="button" data-section="cache" class="btn rounded-0"><span>Cache</span></button>
        </div>
        <div class="setting-m-menu-content" id="content">
            <div id="general" class="section">
                <form id="general-setting-form">
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteTitle">Site Title</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteTitle" placeholder="Site Title"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteMetaTitle">Meta Title</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteMetaTitle" placeholder="Meta Title"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteMetaDes">Meta Description</label>
                        <div class="col-sm-7">
                            <textarea id="siteMetaDes" cols="30" rows="3" placeholder="Meta Description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteKw">Site Keyword (use comma to seperate)</label>
                        <div class="col-sm-7">
                            <textarea id="siteKw" cols="30" rows="3" placeholder="Keyword 1, Keyword 2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <button class="btn btn-primary rounded" id="update-button" type="submit">
                            <i class="fas fa-check-circle"></i> Update
                        </button>
                        <button class="btn btn-primary rounded lh-1" id="loader-button" type="button" style="display: none; padding:11px" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Updating...
                        </button>
                    </div>
                </form>
            </div>
            <div id="logo" class="section">
                <div class="row mb-5">
                    <label for="customer_profit" class="col-sm-3 col-form-label">
                        Site Favicon
                        <div class="d-flex gap-2">
                            <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-fav"><i class="fas fa-pencil-alt"></i></button></div>
                            <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-fav"><i class="fas fa-trash-alt"></i></button></div>
                        </div>
                    </label>
                    <div class="col-sm-8">
                        <img alt="thumbnail" id="site_fav" style="max-width:100%; max-height:200px" class="rounded">
                    </div>
                </div>
                <div class="row mb-5">
                    <label for="customer_profit" class="col-sm-3 col-form-label">
                        Site Logo
                        <div class="d-flex gap-2">
                            <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-logo"><i class="fas fa-pencil-alt"></i></button></div>
                            <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-logo"><i class="fas fa-trash-alt"></i></button></div>
                        </div>
                    </label>
                    <div class="col-sm-8">
                        <img alt="thumbnail" id="site_logo" style="max-width:100%; max-height:200px" class="rounded">
                    </div>
                </div>
            </div>
            <div id="theme" class="section">
                <form id="updateThemeColor">
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="selectThemeColor">Choose Theme Color</label>
                        <div class="col-sm-7">
                            <select id="selectThemeColor" style="width: 100%">
                                <option value="preset-1" data-img="{{asset('resource/blue.png')}}">Blue</option>
                                <option value="preset-2" data-img="{{asset('resource/indigo.png')}}">Indogo</option>
                                <option value="preset-3" data-img="{{asset('resource/purple.png')}}">Purple</option>
                                <option value="preset-4" data-img="{{asset('resource/pink.png')}}">Pink</option>
                                <option value="preset-5" data-img="{{asset('resource/red.png')}}">Red</option>
                                <option value="preset-6" data-img="{{asset('resource/orange.png')}}">Orange</option>
                                <option value="preset-7" data-img="{{asset('resource/yellow.png')}}">Yellow</option>
                                <option value="preset-8" data-img="{{asset('resource/green.png')}}">Green</option>
                                <option value="preset-9" data-img="{{asset('resource/teal.png')}}">Teal</option>
                                <option value="preset-10" data-img="{{asset('resource/cyan.png')}}">Cyan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <button class="btn btn-primary rounded" id="themeUpdateBtn" type="submit">
                            <i class="fas fa-check-circle"></i> Update
                        </button>
                        <button class="btn btn-primary rounded" id="themeUpdateBtnLoager" type="button" style="display: none;" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Updating...
                        </button>
                    </div>
                </form>
            </div>
            <div id="social" class="section">
                <form id="social-media-form">

                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteFbUrl">Facebook URL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteFbUrl" placeholder="Facebook URL"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteXUrl">X URL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteXUrl" placeholder="X URL"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteYtUrl">YouTube URL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteYtUrl" placeholder="YouTube URL"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteWaUrl">Whatsapp URL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteWaUrl" placeholder="Whatsapp URL"/>
                        </div>
                    </div>
                    <div class="row mb-4 pb-4 border-bottom align-items-center">
                        <label class="col-sm-5 col-form-label" for="siteTeleUrl">Telegram URL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="siteTeleUrl" placeholder="Telegram URL"/>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <button class="btn btn-primary rounded" id="social-update-button" type="submit">
                            <i class="fas fa-check-circle"></i> Update
                        </button>
                        <button class="btn btn-primary rounded lh-1" id="social-loader-button" type="button" style="display: none; padding:11px" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Updating...
                        </button>
                    </div>
                </form>
            </div>
            <div id="headercode" class="section">
                <form id="header-code-form">
                    <div class="mb-3">
                        <textarea class="form-control" id="siteHeaderCode" cols="30" rows="20" placeholder="Header Code"></textarea>
                    </div>
                    <div class="col-12 mb-4">
                        <button class="btn btn-primary rounded" id="headercode-update-button" type="submit">
                            <i class="fas fa-check-circle"></i> Update
                        </button>
                        <button class="btn btn-primary rounded lh-1" id="headercode-loader-button" type="button" style="display: none; padding:11px" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Updating...
                        </button>
                    </div>
                </form>
            </div>
            <div id="system" class="section">
                <form id="system-setting-form">
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Site Maintainance</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="siteMaintainance" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Send email while place new order [Admin]</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="adminOrderReceiveMail" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Send email while place new order [Customer]</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="customerOrderReceiveMail" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Send email while replay order as success [Customer]</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="customerOrderSuccessMail" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Send email while replay order as rejected [Customer]</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="customerOrderRejecMail" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="col-12 my-4">
                        <button class="btn btn-primary rounded" id="system-update-button" type="submit">
                            <i class="fas fa-check-circle"></i> Update
                        </button>
                        <button class="btn btn-primary rounded lh-1" id="system-loader-button" type="button" style="display: none; padding:11px" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Updating...
                        </button>
                    </div>
                </form>
            </div>
            <div id="cache" class="section">
                <div class="col-12 my-4">
                    <button class="btn btn-primary rounded" id="cache-clear-button" type="button">
                        <i class="fas fa-check-circle"></i> Clear Cache
                    </button>
                    <button class="btn btn-primary rounded" id="cache-loader-button" type="button" style="display: none" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Thumbnail Modal --}}
<div class="modal fade modal-animate" id="addImg" tabindex="-1" aria-labelledby="addIMG" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 950px;">
        <div class="modal-content">
            <div class="modal-header gap-2 overflow-auto">
                <div>
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <label for="uploadimg" class="media-upload-btn"><i class="fas fa-cloud-upload-alt"></i></label>
                        <label class="media-upload-loader"><span class="spinner-border spinner-border-sm" id="loadingSpinnerSuccess" role="status"></span></label>
                        <input type="file" class="form-control py-2" name="image" id="uploadimg" accept="image/*" style="width: 150px; display: none">
                    </form>
                </div>
                <input type="search" class="form-control py-2 media-search" placeholder="Search" style="width: 200px">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 500px; overflow:auto">
                <div class="table-responsive " style="border: 1px solid #efefef">
                    <table id="modal-img-list" class="display table px-5">
                        <thead >
                            <tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon btn-primary page-prev"><i class="fas fa-angle-left"></i></button>
                <button type="button" class="btn btn-icon btn-primary page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                <div class="show-preview"></div>
                <button type="button" class="btn btn-light-primary selectIMG" style="display: none"><i class="fas fa-check-circle"></i> Select</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $('#addImg').on('hidden.bs.modal', function () {
            $('.show-preview').html(``);
            $('.selectIMG').hide();
            $('.media-search').val('');
        });
        initMenu();
        $.ajax({
            url: '{{ route('fetch_settings') }}',
            method: 'GET',
            beforeSend: function() {
                $('.top-loader').show();
            },
            complete: function() {
                $('.top-loader').hide();
            },
            success: function(response) {
                if(response.success){
                    $('#site_fav').attr('src', response.siteFav);
                    $('#site_logo').attr('src', response.siteLogo);
                    $('#siteTitle').val(response.siteTitle || '');
                    $('#siteMetaTitle').val(response.siteMetaTitle || '');
                    $('#siteMetaDes').val(response.siteMetaDes || '');
                    $('#siteKw').val(response.siteKw || '');
                    $('#siteFbUrl').val(response.siteFbUrl || '');
                    $('#siteXUrl').val(response.siteXUrl || '');
                    $('#siteYtUrl').val(response.siteYtUrl || '');
                    $('#siteWaUrl').val(response.siteWaUrl || '');
                    $('#siteTeleUrl').val(response.siteTeleUrl || '');
                    $('#siteHeaderCode').val(response.siteHeaderCode || '');
                    $('#siteMaintainance').prop('checked', response.siteMaintainance == 1);
                    $('#adminOrderReceiveMail').prop('checked', response.adminOrderReceiveMail == 1);
                    $('#customerOrderReceiveMail').prop('checked', response.customerOrderReceiveMail == 1);
                    $('#customerOrderSuccessMail').prop('checked', response.customerOrderSuccessMail == 1);
                    $('#customerOrderRejecMail').prop('checked', response.customerOrderRejecMail == 1);
                    $('#settings').offcanvas('show');
                    if(response.themeColor){
                        $('#selectThemeColor').val(response.themeColor).trigger('change');
                    } else {
                        $('#selectThemeColor').val('preset-8').trigger('change');
                    }
                }
            },
            error: function(xhr, status, error) {
                new Notify({
                    status: 'error',
                    text: 'Something wrong. Try again.',
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
            }
        });
        // UPDATE GENERAL SETTING
        $('#general-setting-form').on('submit', function(event) {
            event.preventDefault();
            const formData = {
                siteTitle: $('#siteTitle').val(),
                siteMetaTitle: $('#siteMetaTitle').val(),
                siteMetaDes: $('#siteMetaDes').val(),
                siteKw: $('#siteKw').val(),
            };
            let missingFields = [];
            if (!formData.siteTitle) {
                missingFields.push('Site title');
            }
            if (!formData.siteMetaTitle) {
                missingFields.push('Site meta title');
            }
            if (!formData.siteMetaDes) {
                missingFields.push('Site meta description');
            }
            if (!formData.siteKw) {
                missingFields.push('Site keyword');
            }
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                new Notify({
                    status: 'error',
                    text: message,
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
                return false;
            }
            $.ajax({
                url: '{{ route('update_general_setting') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#loader-button').show();
                    $('#update-button').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#loader-button').hide();
                    $('#update-button').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });
        // UPDATE THEME COLOR
        $('#updateThemeColor').on('submit', function(event) {
            event.preventDefault();
            const formData = {
                themeColor: $('#selectThemeColor').val(),
            };
            let missingFields = [];
            if (!formData.themeColor) {
                missingFields.push('Theme color');
            }
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                new Notify({
                    status: 'error',
                    text: message,
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
                return false;
            }
            $.ajax({
                url: '{{ route('update_frontend_theme_color') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#themeUpdateBtnLoager').show();
                    $('#themeUpdateBtn').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#themeUpdateBtnLoager').hide();
                    $('#themeUpdateBtn').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });
        // UPDATE SOCIAL MEDIA
        $('#social-media-form').on('submit', function(event) {
            event.preventDefault();
            const formData = {
                siteFbUrl: $('#siteFbUrl').val(),
                siteXUrl: $('#siteXUrl').val(),
                siteYtUrl: $('#siteYtUrl').val(),
                siteWaUrl: $('#siteWaUrl').val(),
                siteTeleUrl: $('#siteTeleUrl').val(),
            };
            $.ajax({
                url: '{{ route('update_social_media') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#social-loader-button').show();
                    $('#social-update-button').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#social-loader-button').hide();
                    $('#social-update-button').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });
        // UPDATE HEADER CODE
        $('#header-code-form').on('submit', function(event) {
            event.preventDefault();
            const formData = {
                siteHeaderCode: $('#siteHeaderCode').val(),
            };
            $.ajax({
                url: '{{ route('update_header_code') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#headercode-loader-button').show();
                    $('#headercode-update-button').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#headercode-loader-button').hide();
                    $('#headercode-update-button').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });
        // UPDATE SYSTEM SETTING
        $('#system-setting-form').on('submit', function(event) {
            event.preventDefault();
            const formData = {
                siteMaintainance: $('#siteMaintainance').prop('checked') ? 1 : 0,
                adminOrderReceiveMail: $('#adminOrderReceiveMail').prop('checked') ? 1 : 0,
                customerOrderReceiveMail: $('#customerOrderReceiveMail').prop('checked') ? 1 : 0,
                customerOrderSuccessMail: $('#customerOrderSuccessMail').prop('checked') ? 1 : 0,
                customerOrderRejecMail: $('#customerOrderRejecMail').prop('checked') ? 1 : 0,
            };
            $.ajax({
                url: '{{ route('update_system_setting') }}',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#system-loader-button').show();
                    $('#system-update-button').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#system-loader-button').hide();
                    $('#system-update-button').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });
        // CLEAR CACHE
        $('#cache-clear-button').on('click', function() {
            $.ajax({
                url: '{{ route('clear_cache') }}',
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#cache-loader-button').show();
                    $('#cache-clear-button').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#cache-loader-button').hide();
                    $('#cache-clear-button').show();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else {
                        errorMessage = error || 'An unknown error occurred.';
                    }
                    new Notify({
                        status: 'error',
                        text: errorMessage,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: 'filled',
                        position: 'left bottom',
                    });
                }
            });
        });


        // MENU FUNCTION INITIALIZE
        function initMenu() {
            $('.section').hide();
            $('#general').show();
            $('#menu button').on('click', function() {
                const section = $(this).data('section');
                $('.section').hide();
                $('#menu button').removeClass('active');
                $(this).addClass('active');
                $('#' + section).show();
            });
        }

        $(document).on('click', '.add-logo', function(){
            var Action = 'add-logo';
            $('#addImg').modal('show');
            loadModalIMG(Action);
        });
        $(document).on('click', '.add-fav', function(){
            var Action = 'add-fav';
            $('#addImg').modal('show');
            loadModalIMG(Action);
        });
        function loadModalIMG(Action){
            if ($.fn.dataTable.isDataTable('#modal-img-list')) {
                $('#modal-img-list').DataTable().clear().destroy();
            }
            var table = $('#modal-img-list').DataTable({
                processing: false,
                serverSide: false,
                lengthChange: false,
                info: false,
                ajax: {
                    url: '{{ route('fetch_modal_img') }}',
                    type: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                },
                columns: [
                    {
                        data: 'media_name',
                        title: 'IMAGE',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data ? `<img src="/media/${data}" alt="Thumbnail" width="70" height="47" class="rounded" >` : 'No Image';
                        }
                    },
                    {
                        data: 'media_name',
                        title: 'NAME',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'media_size',
                        title: 'SIZE',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            if (data) {
                                if (data > 1024 * 1024) {
                                    return (data / (1024 * 1024)).toFixed(2) + ' MB';
                                } else if (data > 1024) {
                                    return (data / 1024).toFixed(2) + ' KB';
                                } else {
                                    return data + ' Bytes';
                                }
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'media_width',
                        title: 'RESOLUTION',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data && row.media_height) {
                                return data + 'x' + row.media_height + ' px';
                            } else {
                                return '-';
                            }
                        }
                    },
                ],
                pageLength: 100,
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_",
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                pagingType: "simple",
                initComplete: function () {
                    $('.dataTables_length select').addClass('form-control dt-select-padding');
                },
                createdRow: function(row, data, dataIndex) {
                    $('td', row).on('click', function() {
                        showSelectBtn(data.media_name, Action);
                        var imageUrl = data.media_name ? "/media/" + data.media_name : "";
                        if (imageUrl) {
                            $('.show-preview').html(`<img src="${imageUrl}" alt="Preview" style="max-width: 100%; max-height: 40px;" class="rounded">`).show();
                        } else {
                            $('.show-preview').hide();
                        }
                    });
                }
            });
            $('.page-prev').on('click', function() {
                table.page('previous').draw('page');
            });
            $('.page-next').on('click', function() {
                table.page('next').draw('page');
            });
            $('.media-search').on('input', function() {
                var searchValue = this.value;
                if (searchValue.length === 0) {
                    table.search('').draw();
                } else {
                    table.search(searchValue).draw();
                }
            });
            $(document).on('imageUploadSuccess', function() {
                table.ajax.reload();
            });
        }
        $(document).ready(function() {
            $('#uploadimg').on('change', function(e) {
                e.preventDefault();
                let formData = new FormData();
                $.each($('#uploadimg')[0].files, function(i, file) {
                    formData.append('image', file);
                });
                $.ajax({
                    url: '{{ route("upload_modal_img") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.top-loader').show();
                        $('.media-upload-btn').hide();
                        $('.media-upload-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                        $('#uploadimg').val('');
                        $('.media-upload-btn').show();
                        $('.media-upload-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: `${response.success ? 'success' : 'error'}`,
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if(response.success){
                            $(document).trigger('imageUploadSuccess');

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $('#response').html('<p>An error occurred while uploading the images.</p>');
                    }
                });
            });
        });
        function showSelectBtn(mediaName, Action) {
            $('.selectIMG').show();
            $('.selectIMG').off('click').on('click', function() {
                $.ajax({
                    url: '/admin/update/logo/' + mediaName + '/' + Action,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            new Notify({
                                status: 'success',
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            $('#addImg').modal('hide');
                            if(response.fav){
                                $('#site_fav').attr('src', '/media/' + mediaName);
                            }
                            if(response.logo){
                                $('#site_logo').attr('src', '/media/' + mediaName);
                                $('#main-logo').attr('src', '/media/' + mediaName);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while updating..');
                    }
                });
            });
        };
        // START - Remove LOGO
        $(document).on('click', '.remove-fav, .remove-logo', function() {
            var action = $(this).hasClass('remove-fav') ? 'remove-fav' : 'remove-logo';
            var isConfirmed = confirm("Are you sure to remove?");
            if (isConfirmed) {
                $.ajax({
                    url: '/admin/remove/logo/' + action,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            new Notify({
                                status: 'success',
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            if(response.fav){
                                $('#site_fav').attr('src', '/resource/fav.png');
                            }
                            if(response.logo){
                                $('#site_logo').attr('src', '/resource/logo.png');
                                $('#main-logo').attr('src', '/resource/logo.png');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while removing..');
                    }
                });
            }
        });
        // END - Remove image

        // Select 2 for Theme Color
        $(document).ready(function() {
            // Initialize Select2
            $('#selectThemeColor').select2({
                templateResult: function(state) {
                    if (!state.id) { return state.text; }
                    var imgUrl = $(state.element).data('img');
                    var $state = $('<span><img src="' + imgUrl + '" style="width: 20px; height: 20px; margin-right: 10px;" />' + state.text + '</span>');
                    return $state;
                },

            });
            $('#selectThemeColor').on('select2:open', function (e) {
                let searchInput = document.querySelector('.select2-search__field');
                if (searchInput) {
                    searchInput.focus();
                }
            });
        });


    });
</script>
@endsection
