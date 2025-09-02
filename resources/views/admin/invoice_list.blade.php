@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Invoice</h5>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="invoice-details" aria-labelledby="announcementLabel" style="width: 850px"></div>

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
                url: '{{ route('fetch_invoice') }}',
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
                    data: 'id',
                    title: 'ID',
                    className: 'text-left',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'created_at',
                    title: 'CREATED',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
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
                    data: 'customer_name',
                    title: 'CUSTOMER',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'invoice_for',
                    title: 'INVOICE FOR',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'invoice_amount',
                    title: 'AMOUNT',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data + ' ' + row.customer_currency;
                    }
                },
                {
                    data: 'payment_gateway',
                    title: 'GATEWAY',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'trx_id',
                    title: 'TRXID',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'total_paid',
                    title: 'TOTAL PAID',
                    className: 'text-left',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? data + ' ' + row.payment_currency : '-';
                    }
                },
                {
                    data: 'invoice_status',
                    title: 'STATUS',
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
            order: [[0, 'desc']],
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

        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = ("0" + date.getDate()).slice(-2);
            let month = date.toLocaleString('en-US', { month: 'long' });
            let year = date.getFullYear();
            let hours = ("0" + date.getHours()).slice(-2);
            let minutes = ("0" + date.getMinutes()).slice(-2);
            return `${day} ${month} ${year} at ${hours}:${minutes}`;
        }

        // Show offcanvas with user data
        function loaduserDetails(invoiceID) {
            $.ajax({
                url: '/admin/fetch-invoice-details/' + invoiceID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('#invoice-details').offcanvas('show');

                        switch (response.invoice.invoice_status) {
                            case 'Paid':
                                statusClass = 'badge bg-light-primary';
                                break;
                            case 'Unpaid':
                                statusClass = 'badge bg-light-warning';
                                break;
                            default:
                                statusClass = 'badge bg-secondary';
                        }
                        let detailsHtml = `
                            <div class="offcanvas-header bg-light-primary">
                                <h5 class="offcanvas-title" id="announcementLabel">INVOICE #${response.invoice.id}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <h5>INVOICE INFORMATION</h5>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Invoice Status</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);"> <span class="${statusClass} fs-6">${response.invoice.invoice_status}</span></div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Invoice For</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 123px);">${response.invoice.invoice_for}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Description</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.invoice_title}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">AMOUNT</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.invoice_amount ? response.invoice.invoice_amount + ' ' + response.invoice.customer_currency : '-'}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Gateway</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.payment_gateway ? response.invoice.payment_gateway : '-'}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">TRXID</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.trx_id ? response.invoice.trx_id : '-'}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">TOTAL PAID</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.total_paid ? response.invoice.total_paid + ' ' + response.invoice.payment_currency : '-'}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">CREATED</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${formatDate(response.invoice.created_at)}</div>
                                </div>

                                <h5 class="mt-4">CUSTOMER INFORMATION</h5>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Name</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 123px);">${response.invoice.customer_name}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Currency</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.customer_currency}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Mobile</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.customer_mobile}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 130px;">Email</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 130px);">${response.invoice.customer_email}</div>
                                </div>
                            </div>

                        `;
                        $('#invoice-details').html(detailsHtml);
                    }
                    else{
                        $('#invoice-details').html('<p>Error loading details. Please try again.</p>');
                    }

                },
                error: function(xhr, status, error) {
                    $('#invoice-details').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }


    })
</script>
@endsection
