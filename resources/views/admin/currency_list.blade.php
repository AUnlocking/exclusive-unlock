@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Currency</h5>
                    <div class="d-flex gap-1">
                        <input type="search" class="form-control py-2" id="customer-search" placeholder="Search" />
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="currency-details" aria-labelledby="announcementLabel"></div>
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
            $('#currency-details').on('hide.bs.offcanvas', function () {
                $('.currency-data').empty();
            });
        });
        // Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_currency') }}',
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
                { data: 'country', title: 'COUNTRY', className: 'text-left', orderable: false, searchable: true },
                { data: 'code', title: 'CODE', className: 'text-left', orderable: false, searchable: true },
                { data: 'name', title: 'NAME', className: 'text-left', orderable: false, searchable: true },
                { data: 'icon', title: 'ICON', className: 'text-left', orderable: false, searchable: true },
                { data: 'rate', title: 'RATE', className: 'text-left', orderable: false, searchable: true },
                { data: 'type', title: 'TYPE', className: 'text-left', orderable: false, searchable: true,
                    render: function(data) {
                        if (data === 'Default') return 'Default';
                        else return 'N/A';
                    }
                 },
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
                    loadCurrencyDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });
        $('#customer-search').on('input', function() {
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
        function loadCurrencyDetails(currencyID) {
            $.ajax({
                url: '/admin/fetch/currency-details/' + currencyID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    $('#currency-details').offcanvas('show');
                    let canvaBodyHtml = `
                        <div class="offcanvas-header bg-light-primary">
                            <h5 class="offcanvas-title" id="announcementLabel">${'Currency ' + '(' + response.currency.code + ')'}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="row mb-3">
                                <label for="status" class="col-sm-5 col-form-label">Currency Status</label>
                                <div class="col-sm-7">
                                    <select class="form-select" id="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="rate" class="col-sm-5 col-form-label">Rate (1 USD = ?)</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="rate" placeholder="Rate" required />
                                        <span class="input-group-text">${response.currency.code}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offcanvas-footer">
                            <button type="button" class="btn btn-primary rounded-0 w-100" id="update-currency" style="height: 42px">
                                <i class="fas fa-check-circle"></i> Update
                                <span class="spinner-border spinner-border-sm d-none" id="loadingSpinnerSuccess" role="status"></span>
                            </button>
                        </div>
                    `;
                    $('#currency-details').html(canvaBodyHtml);
                    $('#status').val(response.currency.status || '');
                    $('#rate').val(response.currency.rate || '');
                    $('#rate').on('input', function() {
                        this.value = this.value.replace(/[^0-9.]/g, '');
                        if ((this.value.match(/\./g) || []).length > 1) {
                            this.value = this.value.replace(/\.(?=.*\.)/, '');
                        }
                        if (this.value.length > 10) {
                            this.value = this.value.slice(0, 10);
                        }
                    });
                    // FORM SUBMIT - CUSTOMER PROFILE UPDATE
                    $('#update-currency').off('click').on('click', function() {
                        const formData = {
                            status: $('#status').val(),
                            rate: $('#rate').val(),
                        };
                        if (formData.rate < 1) {
                            new Notify({
                                status: 'error',
                                text: 'Currency rate must be 1 or higher',
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
                            url: '/admin/update/currency/' + currencyID,
                            method: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('.top-loader').show();
                                $('#update-currency').prop('disabled', true);
                                $('#loadingSpinnerSuccess').removeClass('d-none');
                            },
                            complete: function() {
                                $('.top-loader').hide();
                                $('#update-currency').prop('disabled', false);
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
                                    $('#currency-details').offcanvas('hide');
                                    reloadDataTable();
                                }
                            },
                        });
                    });
                },
                error: function(xhr, status, error) {
                    $('#currency-details').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }
    });
</script>
@endsection
