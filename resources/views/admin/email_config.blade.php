@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Email Configuration</h5>
                    <div class="d-flex gap-1">
                        <input type="search" class="form-control py-2" id="emailconfig-search" placeholder="Search" />
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="emailconfig-details" aria-labelledby="announcementLabel" style="width: 850px"></div>
@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_email_configs') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                error: function(xhr, error, thrown) {
                    new Notify({
                        status: 'error',
                        title: 'ERROR',
                        text: 'An error occurred while fetching data. Please try again',
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
            },
            columns: [
                { data: 'name', title: 'COFIGURATION', className: 'text-left', orderable: false, searchable: true },
                { data: 'mail_driver', title: 'DRIVER', className: 'text-left', orderable: false, searchable: true },
                {
                    data: 'mail_host',
                    title: 'HOST',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'mail_port',
                    title: 'PORT',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
                { data: 'encryption', title: 'ENC:', className: 'text-left', orderable: false, searchable: true },
                {
                    data: 'status',
                    title: '<span style="float:right">STATUS</span>',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Active') return '<span class="badge bg-light-success fs-6" style="float:right">Active</span>';
                        else if (data === 'Inactive') return '<span class="badge bg-light-danger fs-6" style="float:right">Inactive</span>';
                    }
                }
            ],
            order: [[5, 'asc']],
            pageLength: 100,
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadEmailDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });
        $('#emailconfig-search').on('input', function() {
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
        // Show offcanvas with Customer data
        function loadEmailDetails(configID) {
            $.ajax({
                url: '/admin/fetch/email-configs/' + configID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    $('#emailconfig-details').offcanvas('show');
                    let canvaBodyHtml = `
                        <div class="offcanvas-header bg-light-primary">
                            <h5 class="offcanvas-title" id="announcementLabel">${'Configuration ' + '(' + response.config.name + ')'}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="host" class="col-sm-3 col-form-label">Host</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="host" placeholder="Host" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="port" class="col-sm-3 col-form-label">Port</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="port" placeholder="Port" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" placeholder="Username" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="password" placeholder="Password" required />
                                </div>
                            </div>
                        </div>
                        <div class="offcanvas-footer">
                            <button type="button" class="btn btn-primary rounded-0 w-100" id="update-configs" style="height: 42px">
                                <i class="fas fa-check-circle"></i> Update
                                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinnerSuccess" role="status"></span>
                            </button>
                        </div>
                    `;
                    $('#emailconfig-details').html(canvaBodyHtml);
                    $('#status').val(response.config.status || '');
                    $('#host').val(response.config.mail_host || '');
                    $('#port').val(response.config.mail_port || '');
                    $('#username').val(response.config.username || '');
                    $('#password').val(response.config.password || '');

                    // FORM SUBMIT - EMAIL CONFIG UPDATE
                    $('#update-configs').off('click').on('click', function() {
                        const formData = {
                            status: $('#status').val(),
                            host: $('#host').val(),
                            port: $('#port').val(),
                            username: $('#username').val(),
                            password: $('#password').val(),
                        };
                        let missingFields = [];
                        if (!formData.status) {
                            missingFields.push('Status');
                        }
                        if (!formData.host) {
                            missingFields.push('Host');
                        }
                        if (!formData.port) {
                            missingFields.push('Port');
                        }
                        if (!formData.username) {
                            missingFields.push('Username');
                        }
                        if (!formData.password) {
                            missingFields.push('Password');
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
                            url: '/admin/update/email-configs/' + configID,
                            method: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('.top-loader').show();
                                $('#update-configs').prop('disabled', true);
                                $('#loadingSpinnerSuccess').removeClass('d-none');
                            },
                            complete: function() {
                                $('.top-loader').hide();
                                $('#update-configs').prop('disabled', false);
                                $('#loadingSpinnerSuccess').addClass('d-none');
                            },
                            success: function(response) {
                                new Notify({
                                    status: `${response.success ? 'success' : 'error'}`,
                                    text: `${response.message}`,
                                    effect: 'fade',
                                    speed: 300,
                                    showIcon: true,
                                    showCloseButton: false,
                                    autoclose: true,
                                    autotimeout: 5000,
                                    notificationsGap: null,
                                    notificationsPadding: null,
                                    type: 'filled',
                                    position: 'left bottom',
                                });
                                if(response.success){
                                    $('#emailconfig-details').offcanvas('hide');
                                    reloadDataTable();
                                }
                            },
                        });
                    });
                },
                error: function(xhr, status, error) {
                    $('#emailconfig-details').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }
    });
</script>
@endsection
