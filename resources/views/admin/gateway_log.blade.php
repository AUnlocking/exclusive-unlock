@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Gateway Log</h5>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive ">
                    <table id="data-table" class="display table px-5">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="log-details" aria-labelledby="announcementLabel" style="width: 850px"></div>

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
            serverSide: false,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_gateway_log') }}',
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
                    data: 'created_at',
                    title: 'CREATED',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data) {
                            const date = new Date(data);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}-${month}-${year}`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'payment_gateway',
                    title: 'GATEWAY',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'payment_for',
                    title: 'PAYMENT FOR',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'payment_amount',
                    title: 'AMOUNT',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: null,
                    title: 'CUS ID & NAME',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return row.customer_id + ' - ' + row.customer_name; // Combine customer ID and name
                    }
                },
                {
                    data: 'invoice_id',
                    title: 'INVOICE',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return 'Invoice-' + data;
                    }
                },
                {
                    data: 'invoice_status',
                    title: 'INV. STATUS',
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data === 'Paid') return '<span class="badge bg-light-success fs-6" style="width:80px">Paid</span>';
                        else if (data === 'Unpaid') return '<span class="badge bg-light-warning fs-6" style="width:80px">Unpaid</span>';
                        else return '-';
                    }
                }

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
            initComplete: function () {
                $('.dataTables_length select').addClass('form-control dt-select-padding');
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            },
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loaduserDetails(data.id);
                });
            },
        });
        // Function to reload DataTable
        function reloadDataTable() {
            table.ajax.reload(null, false);
        }
        // Add Custom Paginate for service data table
        $('.ser-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.ser-page-next').on('click', function() {
            table.page('next').draw('page');
        });


        // Show offcanvas with user data
        function loaduserDetails(logID) {
            $.ajax({
                url: '/admin/fetch/gateway-log/' + logID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('#log-details').offcanvas('show');
                        let detailsHtml = `
                            <div class="offcanvas-header bg-light-primary">
                                <h5 class="offcanvas-title" id="announcementLabel">Gateway Log</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="row mb-3">
                                    <label for="create_payment" class="col-sm-4 col-form-label">Create Response</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="create_payment" placeholder="Create Response" cols="10" rows="15"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="execute_payment" class="col-sm-4 col-form-label">Execute Response</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="execute_payment" placeholder="Create Response" cols="10" rows="15"></textarea>
                                    </div>
                                </div>
                            </div>

                        `;
                        $('#log-details').html(detailsHtml);
                        $('#create_payment').val(response.gatewayLog.create_payment);
                        $('#execute_payment').val(response.gatewayLog.execute_payment);
                    }
                    else{
                        $('#log-details').html('<p>Error loading details. Please try again.</p>');
                    }

                },
                error: function(xhr, status, error) {
                    $('#log-details').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }


    })
</script>
@endsection
