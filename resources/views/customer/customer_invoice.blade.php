@extends('layouts.frontend')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('customer_dashboard')}}" class="breadcrumb-item active">My Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">My Invoive</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h5>My Invoice</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive ">
                <table id="customer-invoice-table" class="display">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-icon btn-primary invoice-page-prev"><i class="fas fa-angle-left"></i></button>
            <button type="button" class="btn btn-icon btn-primary invoice-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
</div>
@endsection
@section('seo')
<title>{{'My Invoice - ' . $siteTitle}}</title>
<meta name="description" content="My Invoice"/>
<meta name="keywords" content="My Invoice"/>
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
        var table = $('#customer-invoice-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            searching: false,
            ajax: {
                url: '{{ route('fetch_customer_invoice') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                }
            },
            columns: [
                { data: 'id', title: 'ID', className: 'text-left px-2 ps-4', orderable: true, searchable: true },
                {
                    data: 'created_at',
                    title: 'DATE & TIME',
                    className: 'text-left px-2',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        var date = new Date(data);
                        var day = ("0" + date.getDate()).slice(-2);
                        var month = ("0" + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear();
                        var hours = ("0" + date.getHours()).slice(-2);
                        var minutes = ("0" + date.getMinutes()).slice(-2);
                        return day + '-' + month + '-' + year + ' ' + hours + ':' + minutes;
                    }
                },
                { data: 'payment_gateway', title: 'GATEWAY', className: 'text-left px-2', orderable: true, searchable: true },
                { data: 'trx_id', title: 'TRX ID', className: 'text-left px-2', orderable: true, searchable: true },
                {
                    data: 'invoice_amount',
                    title: 'AMOUNT',
                    className: 'text-left px-2',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var currencyCode = row.customer_currency;
                        var formattedAmount = parseFloat(data).toFixed(2);
                        return formattedAmount + ' ' + currencyCode;
                    }
                },
                {
                    data: 'total_paid',
                    title: 'TOTAL PAID',
                    className: 'text-left px-2',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var currencyCode = row.payment_currency;
                        var formattedAmount = parseFloat(data).toFixed(2);
                        return formattedAmount + ' ' + currencyCode;
                    }
                },
                {
                    data: 'invoice_status',
                    title: 'STATUS',
                    className: 'text-end px-2 pe-4',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data === 'Paid') {
                            return `<span class="badge bg-success text-uppercase py-2">${data}</span>`;
                        }
                        else{
                            return `<span class="badge bg-danger text-uppercase py-2">${data}</span>`;
                        }
                    }
                },
            ],
            order: [[0, 'desc']],
            pageLength: 100,
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });
        // Add Custom Paginate for service data table
        $('.invoice-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.invoice-page-next').on('click', function() {
            table.page('next').draw('page');
        });
    });
</script>
@endsection
