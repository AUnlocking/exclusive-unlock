@auth
    @if(Auth::user()->role === 'Admin')
        @extends('layouts.admin')
        @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header" style="padding: 12px 15px">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h5 class="mb-3 mb-sm-0">USER</h5>
                            <div class="d-flex gap-1">
                                <input type="search" class="form-control py-2" id="user-search" placeholder="Search" />
                                <button type="button" class="btn btn-light-primary border-primary rounded py-2" data-bs-toggle="modal" data-bs-target="#addNewuser"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive ">
                            <table id="data-table" class="display px-5">
                                <thead>
                                    <tr>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="padding: 12px 15px">
                        <button type="button" class="btn btn-icon btn-light-primary ser-page-prev"><i class="fas fa-angle-left"></i></button>
                        <button type="button" class="btn btn-icon btn-light-primary ser-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Canvas --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="user-details" aria-labelledby="announcementLabel" style="width: 850px"></div>
        {{-- Add New User - Modal --}}
        <div class="modal fade modal-animate" id="addNewuser" tabindex="-1" aria-labelledby="addNewuser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="new-user-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewuserLabel">Add new user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="new-email" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="new-name" placeholder="Name" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="new-mobile" placeholder="Mobile" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="new-role" required>
                                        <option value="">--</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Editor">Editor</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="new-update-button" type="submit">
                                <i class="fas fa-check-circle"></i> Add
                            </button>
                            <button class="btn btn-primary lh-1" id="new-loader-button" type="button" style="display:none;padding:11px" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
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
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // IF OFFCANVAS HIDE THEN CLEAR ALL DATA
                $(document).ready(function() {
                    $('#user-details').on('hide.bs.offcanvas', function () {
                        $('.user-data').empty();
                    });
                    $('#addImg').on('hidden.bs.modal', function () {
                        $('.show-preview').html(``);
                        $('.selectIMG').hide();
                        $('.media-search').val('');
                    });
                });
                $('div.dataTables_filter').hide();
                // Data Table
                var table = $('#data-table').DataTable({
                    processing: false,
                    serverSide: false,
                    lengthChange: false,
                    info: false,
                    footer: false,
                    ajax: {
                        url: '{{ route('fetch_user') }}',
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
                            data: 'logo',
                            title: 'AVATAR',
                            className: 'text-left',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return data ? `<img src="${data}" alt="Thumbnail" height="28" width="28" style="max-width: 100%;" class="rounded-circle">` : `<img src="/resource/admin-logo.webp" alt="Thumbnail" height="28" width="28" style="max-width: 100%;" class="rounded-circle">`;
                            }
                        },
                        {
                            data: 'name',
                            title: 'NAME',
                            className: 'text-left',
                            orderable: true,
                            searchable: true,
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        { data: 'email', title: 'EMAIL', className: 'text-left', orderable: true, searchable: true },
                        {
                            data: 'mobile',
                            title: 'Mobile',
                            className: 'text-left',
                            orderable: true,
                            searchable: true,
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'role',
                            title: '<span class="float-end">ROLE</span>',
                            className: 'text-left',
                            orderable: true,
                            searchable: true,
                            render: function(data, type, row) {
                                const bgColor = data === 'Admin' ? 'badge bg-light-success fs-6' : 'badge bg-light-primary fs-6';
                                let icon = '';
                                if (row.id === 1) {
                                    icon = '<i class="fas fa-user-lock"></i>';
                                } else if (data === 'Admin') {
                                    icon = '<i class="fas fa-user-cog"></i>';
                                } else if (data === 'Editor') {
                                    icon = '<i class="fas fa-user-alt"></i>';
                                }
                                return `<span class="float-end ${bgColor}">${icon} ${data}</span>`;
                            }

                        },
                    ],
                    order: [[1, 'desc']],
                    pageLength: 100,
                    createdRow: function(row, data, dataIndex) {
                        $('td', row).on('click', function() {
                            loaduserDetails(data.id);
                        });
                    },
                    drawCallback: function(settings) {
                        var api = this.api();
                        var totalEntries = api.page.info().recordsTotal;
                        $('.card-header h5').text('User: ' + totalEntries);
                        $('#userCount').text(totalEntries);
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                    }
                });
                $('#user-search').on('input', function() {
                    var searchValue = this.value;
                    if (searchValue.length === 0) {
                        table.search('').draw();
                    } else {
                        table.search(searchValue).draw();
                    }
                });
                $('.ser-page-prev').on('click', function() {
                    table.page('previous').draw('page');
                });
                $('.ser-page-next').on('click', function() {
                    table.page('next').draw('page');
                })
                // Function to reload DataTable
                function reloadDataTable() {
                    table.ajax.reload(null, false);
                }
                // Show offcanvas with user data
                function loaduserDetails(userId) {
                    $.ajax({
                        url: '/admin/fetch/user-info/' + userId,
                        method: 'GET',
                        beforeSend: function() {
                            $('.top-loader').show();
                        },
                        complete: function() {
                            $('.top-loader').hide();
                        },
                        success: function(response) {
                            $('#user-details').offcanvas('show');
                            let detailsHtml = `
                                <div class="offcanvas-header bg-light-primary">
                                    <h5 class="offcanvas-title" id="announcementLabel">${response.user.name}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body" style="padding:0">
                                    <div class="d-block d-md-flex">
                                        <div class="customer-m-menu" id="menu">
                                            <button type="button" data-section="general" class="active btn rounded-0"><span>General</span></button>
                                            <button type="button" data-section="avatar" class="btn rounded-0"><span>Avatar</span></button>
                                            <button type="button" data-section="password" class="btn rounded-0"><span>Password</span></button>
                                            <button type="button" data-section="2fa" class="btn rounded-0"><span>Google 2FA</span></button>
                                            <button type="button" data-section="account" class="btn rounded-0"><span>Account</span></button>
                                        </div>
                                        <div class="customer-m-menu-content" id="content">
                                            <div id="general" class="section">
                                                <form id="user-form">
                                                    <input type="hidden" name="user_id" id="user_id" />
                                                    <div class="row mb-3">
                                                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="name" placeholder="Name" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="email" placeholder="Email" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="mobile" placeholder="Mobile"/>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="role" class="col-sm-3 col-form-label">Role</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-select" id="role">
                                                                <option value="Admin">Admin</option>
                                                                <option value="Editor">Editor</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-end mb-4">
                                                        <button class="btn btn-primary rounded" id="update-button" type="submit">
                                                            <i class="fas fa-check-circle"></i> Update
                                                        </button>
                                                        <button class="btn btn-primary rounded lh-1" id="loader-button" type="button" style="display: none; padding:11px" disabled>
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            Loading...
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="avatar" class="section">
                                                <div class="row mb-3">
                                                    <label for="customer_profit" class="col-sm-3 col-form-label">
                                                        Avatar
                                                        <div class="d-flex gap-2">
                                                            <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-thumb"><i class="fas fa-pencil-alt"></i></button></div>
                                                            <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-thumb"><i class="fas fa-trash-alt"></i></button></div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <img src="${response.avatar}" alt="thumbnail" height="170" width="170" id="avatar-image" style="height:170px; max-width:100%" class="rounded-circle">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="password" class="section">
                                                <form id="pass-form">
                                                    <div class="row mb-3">
                                                        <label for="new_pass" class="col-sm-3 col-form-label">New Password</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="new_pass" placeholder="********" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="confirm_pass" class="col-sm-3 col-form-label">Confirm Password</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="confirm_pass" placeholder="********" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 text-end mb-4">
                                                        <button class="btn btn-primary rounded" id="pass-button" type="submit">
                                                            <i class="fas fa-check-circle"></i> Update
                                                        </button>
                                                        <button class="btn btn-success rounded lh-1" id="pass-loader-button" type="button" style="display: none; padding:11px" disabled>
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            Updating...
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="2fa" class="section"></div>
                                            <div id="account" class="section">
                                                <form id="del-form">
                                                    <div class="delete-cart">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title">DELETE ACCOUNT</h5>
                                                                <div>
                                                                    <button class="btn btn-light-danger" id="delBtn" type="submit">
                                                                        <i class="fas fa-trash-alt"></i> Delete
                                                                    </button>
                                                                    <button class="btn btn-danger lh-1" id="delBtnLoader" type="button" style="display: none; padding:11px" disabled>
                                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        Deleting...
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            `;
                            $('#user-details').html(detailsHtml);
                            $('#user_id').val(response.user.id || '');
                            $('#name').val(response.user.name || '');
                            $('#email').val(response.user.email || '');
                            $('#mobile').val(response.user.mobile || '');
                            $('#role').val(response.user.role || '');
                            // MENU
                            initMenu(response.user.id);
                            // FORM SUBMIT - USER PROFILE UPDATE
                            $('#user-form').on('submit', function(event) {
                                event.preventDefault();
                                const formData = {
                                    name: $('#name').val(),
                                    email: $('#email').val(),
                                    mobile: $('#mobile').val(),
                                    role: $('#role').val(),
                                };
                                let missingFields = [];
                                if (!formData.name) {
                                    missingFields.push('User name');
                                }
                                if (!formData.email) {
                                    missingFields.push('User email');
                                }
                                if (!formData.mobile) {
                                    missingFields.push('User mobile');
                                }
                                if (!formData.role) {
                                    missingFields.push('User role');
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
                                    url: '/admin/update/user-info/' + userId,
                                    method: 'POST',
                                    data: formData,
                                    beforeSend: function() {
                                        $('.top-loader').show();
                                        $('#update-button').hide();
                                        $('#loader-button').show();
                                    },
                                    complete: function() {
                                        $('.top-loader').hide();
                                        $('#update-button').show();
                                        $('#loader-button').hide();
                                    },
                                    success: function(response) {
                                        if(response.success){
                                            loaduserDetails(userId);
                                            reloadDataTable();
                                        }
                                        new Notify({
                                            status: response.success ? 'success' : 'error',
                                            text: response.message,
                                            effect: 'fade',
                                            speed: 300,
                                            customClass: '',
                                            customIcon: '',
                                            showIcon: true,
                                            showCloseButton: false,
                                            autoclose: true,
                                            autotimeout: 3000,
                                            notificationsGap: null,
                                            notificationsPadding: null,
                                            type: 'filled',
                                            position: 'left bottom',
                                            customWrapper: '',
                                        });
                                    }
                                });
                            });
                            // FORM SUBMIT - UPDATE PASSWORD
                            $('#pass-form').on('submit', function(event) {
                                event.preventDefault();
                                const formData = {
                                    newPass: $('#new_pass').val(),
                                    confirmPass: $('#confirm_pass').val(),
                                };

                                let missingFields = [];
                                if (!formData.newPass) {
                                    missingFields.push('New password');
                                }
                                if (!formData.confirmPass) {
                                    missingFields.push('Confirm password');
                                }
                                if (formData.newPass && formData.confirmPass && formData.newPass !== formData.confirmPass) {
                                    missingFields.push('Passwords do not match');
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
                                    url: '/admin/update/user-pass/' + userId,
                                    method: 'POST',
                                    data: formData,
                                    beforeSend: function() {
                                        $('.top-loader').show();
                                        $('#pass-button').hide();
                                        $('#pass-loader-button').show();
                                    },
                                    complete: function() {
                                        $('.top-loader').hide();
                                        $('#pass-button').show();
                                        $('#pass-loader-button').hide();
                                    },
                                    success: function(response) {
                                        new Notify({
                                            status: response.success ? 'success' : 'error',
                                            text: response.message,
                                            effect: 'fade',
                                            speed: 300,
                                            customClass: '',
                                            customIcon: '',
                                            showIcon: true,
                                            showCloseButton: false,
                                            autoclose: true,
                                            autotimeout: 3000,
                                            notificationsGap: null,
                                            notificationsPadding: null,
                                            type: 'filled',
                                            position: 'left bottom',
                                            customWrapper: '',
                                        });
                                        if(response.success){
                                            $('#pass-form')[0].reset();
                                        }
                                    }
                                });
                            });
                            // FORM SUBMIT - DELETE USER
                            $('#del-form').on('submit', function(event) {
                                event.preventDefault();
                                if (confirm("Are you sure you want to delete this user?")) {
                                    $.ajax({
                                        url: '/admin/del/user/' + userId,
                                        method: 'POST',
                                        beforeSend: function() {
                                            $('.top-loader').show();
                                            $('#delBtn').hide();
                                            $('#delBtnLoader').show();
                                        },
                                        complete: function() {
                                            $('.top-loader').hide();
                                            $('#delBtn').show();
                                            $('#delBtnLoader').hide();
                                        },
                                        success: function(response) {
                                            new Notify({
                                                status: response.success ? 'success' : 'error',
                                                text: response.message,
                                                effect: 'fade',
                                                speed: 300,
                                                customClass: '',
                                                customIcon: '',
                                                showIcon: true,
                                                showCloseButton: false,
                                                autoclose: true,
                                                autotimeout: 3000,
                                                notificationsGap: null,
                                                notificationsPadding: null,
                                                type: 'filled',
                                                position: 'left bottom',
                                                customWrapper: '',
                                            });
                                            if(response.success){
                                                $('#user-details').offcanvas('hide');
                                                reloadDataTable();
                                            }
                                        }
                                    });
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            $('#user-details').html('<p>Error loading details. Please try again.</p>');
                        },
                    });
                }
                // MENU FUNCTION INITIALIZE
                function initMenu(userId) {
                    $('.section').hide();
                    $('#general').show();
                    $('#menu button').on('click', function() {
                        const section = $(this).data('section');
                        $('.section').hide();
                        $('#menu button').removeClass('active');
                        $(this).addClass('active');
                        $('#' + section).show();
                        if (section === '2fa') {fetch2FA(userId);}
                    });
                }
                $(document).on('click', '.add-thumb, .add-screenshot', function(){
                    var userID = $('#user_id').val();
                    var Action = 'add-thumb';
                    $('#addImg').modal('show');
                    loadModalIMG(userID, Action);
                });
                function loadModalIMG(userID, Action){
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
                                showSelectBtn(data.media_name, userID, Action);
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
                function showSelectBtn(mediaName, userID, Action) {
                    $('.selectIMG').show();
                    $('.selectIMG').off('click').on('click', function() {
                        $.ajax({
                            url: '/admin/user/add-img/' + userID + '/' + Action + '/' + mediaName,
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
                                    $('#avatar-image').attr('src', '/media/' + mediaName);
                                    reloadDataTable();
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('Error occurred while updating..');
                            }
                        });
                    });
                };
                // START - Remove image
                $(document).on('click', '.remove-thumb', function() {
                    var userID = $('#user_id').val();
                    var action = 'remove-thumb';
                    var isConfirmed = confirm("Are you sure to remove this avatar?");
                    if (isConfirmed) {
                        $.ajax({
                            url: '/admin/user/remove-img/' + userID + '/' + action,
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
                                    $('#avatar-image').attr('src', '/resource/admin-logo.webp');
                                    reloadDataTable();
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('Error occurred while removing..');
                            }
                        });
                    }
                });
                // END - Remove image

                // Fetch 2FA
                function fetch2FA(userId) {
                    $('#2fa').html(`
                        <div class="card" aria-hidden="true">
                            <div class="card-body">
                                <h5 class="card-title placeholder-glow"><span class="placeholder col-3 rounded" style="background:#eaeffc"></span></h5>
                                <div class="btn btn-primary disabled placeholder col-1" aria-disabled="true" style="padding:6px 30px; background:#eaeffc; border:0"></div>
                            </div>
                        </div>
                    `);

                    $.ajax({
                        url: '/admin/user/fetch-2fa/' + userId,
                        method: 'GET',
                        beforeSend: function() {
                            $('.top-loader').show();
                        },
                        complete: function() {
                            $('.top-loader').hide();
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#2fa').html(`
                                    <div class="block-cart">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Google 2FA</h5>
                                                <div class="form-check form-switch custom-switch-v1">
                                                    <input class="form-check-input input-primary" type="checkbox" id="2faBtn" style="padding:15px 30px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="2fa-form"></div>
                                `);

                                if (response.user.google2fa_enabled === 1) {
                                    $('#2faBtn').prop('checked', true);
                                }
                                bind2faChangeEvent(userId);


                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error occurred while fetching 2FA status.');
                        }
                    });
                }
                // Enable/Disable 2FA
                function bind2faChangeEvent(userId) {
                    $('#2faBtn').change(function() {
                        const isChecked = $(this).prop('checked');
                        if (!isChecked) {
                            const isConfirmed = confirm("Are you sure to disable 2FA?");
                            if (!isConfirmed) {
                                $('#2faBtn').prop('checked', true);
                                return false;
                            }
                            $('.2fa-form').hide();
                        }
                        $.ajax({
                            url: '{{ route('admin_update_2fa') }}',
                            method: 'POST',
                            beforeSend: function() {
                                $('.top-loader').show();
                            },
                            complete: function() {
                                $('.top-loader').hide();
                            },
                            data: {
                                _token: '{{ csrf_token() }}',
                                google2fa_status: isChecked ? 1 : 0,
                                userId: userId,
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.disable) {
                                    $('.2fa-form').hide();
                                } else if (response.newqr) {
                                    $('.2fa-form').empty();
                                    $('.2fa-form').show();
                                    const svgData = encodeURIComponent(response.qrCodeSvg);
                                    const svgUrl = 'data:image/svg+xml;charset=utf-8,' + svgData;
                                    $('.2fa-form').html(`
                                        <div class="card">
                                            <h5 class="card-header">Scan QR code with 2FA app</h5>
                                            <div class="card-body">
                                                <img src="${svgUrl}" alt="QR Code">
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
                                    `);
                                    $('#2fa-otp').focus();
                                    $('#2fa-otp').on('input', function() {
                                        var value = $(this).val();
                                        value = value.replace(/[^0-9]/g, '');
                                        if (value.length > 6) {
                                            value = value.substring(0, 6);
                                        }
                                        $(this).val(value);
                                    });
                                    // Verify OTP
                                    $('#verifyOtpForm').on('submit', function (e) {
                                        e.preventDefault();
                                        const formData = {
                                            userId: userId,
                                            twoFaOtp: $('#2fa-otp').val(),
                                            _token: $('input[name="_token"]').val()
                                        };
                                        let missingFields = [];
                                        if (!formData.twoFaOtp) missingFields.push('6 Digit OTP');
                                        if (!formData.userId) missingFields.push('User ID');
                                        if (missingFields.length > 0) {
                                            let message = missingFields.join(', ') + ' is required';
                                            notifier.show('OTP ERROR', message, 'danger', '/resource/high_priority-48.png', 5000);
                                            return false;
                                        }
                                        $.ajax({
                                            url: '{{ route("admin_2fa_verify") }}',
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
                                                    $('.2fa-form').hide();
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
                                    })




                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('Error updating 2FA status.');
                            }
                        });
                    });
                }



            });
        </script>
        @endsection
    @endif
@endauth

