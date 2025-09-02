@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Payment Gateway</h5>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="gateway-details" aria-labelledby="announcementLabel" style="width: 850px"></div>
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
            $('#gateway-details').on('hide.bs.offcanvas', function () {
                $('.gateway-data').empty();
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
                url: '{{ route('fetch_payment_gateway') }}',
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
                {
                    data: 'LOGO',
                    title: 'LOGO',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data ? `<img src="${data}" alt="Thumbnail" height="33" width="50" style="max-width: 100%;" class="rounded">` : 'No Image';
                    }
                },
                { data: 'NAME', title: 'GATEWAY NAME', className: 'text-left', orderable: true, searchable: true },
                { data: 'CURRENCY_CODE', title: 'CURRENCY', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'CHARGE',
                    title: 'CHARGE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data ? data + ' %' : '';
                    }
                },
                { data: 'COUNTRY', title: 'AVAILAVLE IN', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'STATUS',
                    title: '<span style="float:right">STATUS</span>',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Active') return '<span class="badge bg-light-success fs-6" style="float:right">Active</span>';
                        else if (data === 'Inactive') return '<span class="badge bg-light-danger fs-6" style="float:right">Inactive</span>';
                        else return '-';
                    }
                }
            ],
            order: [[0, 'asc']],
            pageLength: 100,
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadGatewayDetails(data.id);
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
        function loadGatewayDetails(gatewayID) {
            $.ajax({
                url: '/admin/fetch/payment-gateway/' + gatewayID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('#gateway-details').offcanvas('show');
                        let canvaBodyHtml = '';

                        if (response.gateway.NAME === 'Bkash') {
                            @include('admin.include.gateway_bkash')
                        } else if  (response.gateway.NAME === 'Binance') {
                            @include('admin.include.gateway_binance')
                        }
                        else if  (response.gateway.NAME === 'Binance - C2C') {
                            @include('admin.include.gateway_binance_c2c')
                        }
                        $('#bkash_charge, #binance_charge').on('input', function() {
                            this.value = this.value.replace(/[^0-9.]/g, '');
                            if ((this.value.match(/\./g) || []).length > 1) {
                                this.value = this.value.replace(/\.(?=.*\.)/, '');
                            }
                            if (parseFloat(this.value) > 100) {
                                this.value = '100';
                            } else if (parseFloat(this.value) < 0) {
                                this.value = '0';
                            }
                            if (this.value.includes('.')) {
                                this.value = this.value.slice(0, this.value.indexOf('.') + 3);
                            }
                            if (this.value.length > 5) {
                                this.value = this.value.slice(0, 5);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#gateway-details').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }
    });
</script>
@endsection
