@extends('layouts.frontend')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('customer_dashboard')}}" class="breadcrumb-item active">My Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Order History</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header service-card-header">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h5 class="mb-3 mb-sm-0">Order History</h5>
                <div class="d-flex gap-2">
                    <input type="search" class="form-control py-2" id="order-search" placeholder="Search"  />
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive ">
                <table id="order-history-table" class="display">
                    <thead>
                        <tr>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-icon btn-primary order-page-prev"><i class="fas fa-angle-left"></i></button>
            <button type="button" class="btn btn-icon btn-primary order-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
</div>
<div
    class="offcanvas offcanvas-end"
    data-bs-scroll="true"
    tabindex="-1"
    id="orderViewOffcanvas"
    aria-labelledby="offcanvasWithBothOptionsLabel"

    >
    <div class="offcanvas-header border-bottom bg-primary">
        <h5 class="offcanvas-title text-uppercase text-white" id="offcanvasWithBothOptionsLabel"></h5>
        <button type="button" class="btn-close text-reset text-white" data-bs-dismiss="offcanvas" aria-label="Close" style="color: white;"></button>
    </div>
    <div class="offcanvas-body">
        <div class="service-top-info border-bottom pb-1 mb-4">
            <div class="orderTitle fs-5 pb-3 display-1 text-uppercase fw-medium lh-base"></div>
            <div class="orderInputs"></div>
        </div>
        <div class="service-comments-info pb-1 mb-4"></div>
    </div>
</div>
<style>.offcanvas-header .btn-close {filter: invert(1) !important;}</style>
@endsection
@section('seo')
<title>{{'My Order History - ' . $siteTitle}}</title>
<meta name="description" content="My Order History"/>
<meta name="keywords" content="My Order History"/>
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
        var table = $('#order-history-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            dom: 'lrtip',
            ajax: {
                url: '{{ route('fetch_customer_order_history') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                }
            },
            columns: [
                {
                    data: 'service_status',
                    title: 'STATUS',
                    className: 'text-left ps-4 py-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Waiting Action') {
                            return '<span class="badge bg-light-secondary fs-6 " style="width:130px"> <i class="fas fa-hourglass-half"></i> ' + data + '</span>';
                        }
                        if (data === 'In Process') {
                            return '<span class="badge bg-light-warning fs-6" style="width:130px"> <i class="fas fa-clock"></i> ' + data + '</span>';
                        }
                        if (data === 'Success') {
                            return '<span class="badge bg-light-success fs-6" style="width:130px"> <i class="fas fa-check-circle"></i> ' + data + '</span>';
                        }
                        if (data === 'Rejected') {
                            return '<span class="badge bg-light-danger fs-6" style="width:130px"> <i class="fas fa-ban"></i> ' + data + '</span>';
                        }
                        return data;
                    }
                },
                {
                    data: 'id',
                    title: 'O.ID',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '#' + data;
                    }
                },
                {
                    data: 'service_type',
                    title: 'TYPE',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        switch (data) {
                            case 'server_service':
                                return 'Server';
                            case 'credit_service':
                                return 'Credit';
                            case 'imei_service':
                                return 'IMEI';
                            default:
                                return 'Unknown';
                        }
                    }
                },
                {
                    data: 'service_qnt',
                    title: 'QNT',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,

                },
                {
                    data: 'service_price',
                    title: 'PRICE',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        var currencySymbol = '{{ $currency->icon }}';
                        return currencySymbol + data;
                    }
                },
                {
                    data: 'service_title',
                    title: 'SERVICE NAME',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data && data.length > 50) {
                            return `<span title="${data}" data-bs-toggle="tooltip">${data.substring(0, 50)}...</span>`;
                        }
                        return data;
                    },
                    createdCell: function(td) {
                        $(td).tooltip();
                    }
                },
                {
                    data: 'service_input1',
                    title: 'SERVICE FIELD',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data && data.length > 15) {
                            return `<span title="${data}" data-bs-toggle="tooltip">${data.substring(0, 15)}...</span>`;
                        }
                        return data ? data : '-';
                    },
                    createdCell: function(td) {
                        $(td).tooltip();
                    }
                },
                {
                    data: 'created_at',
                    title: 'SUBMITTED ON',
                    className: 'text-left px-2',
                    orderable: true,
                    searchable: true,
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
                {
                    data: 'seen',
                    title: 'VIEW',
                    className: 'text-end pe-3',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        if (data === 'true' && (row.service_status === 'Success' || row.service_status === 'Rejected')) {
                            return '<i class="fas fa-eye fs-4 text-info"></i>';
                        } else {
                            return '<i class="fas fa-eye fs-4 text-secondary"></i>';
                        }
                    }

                }
            ],
            order: [[1, 'desc']],
            pageLength: 100,
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function(event) {
                    viewOrder(data.id)
                });
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }

        });
        // Add Custom Paginate for service data table
        $('.order-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.order-page-next').on('click', function() {
            table.page('next').draw('page');
        });
        // Search
        $('#order-search').on('input', function() {
            var searchValue = this.value;
            if (searchValue.length === 0) {
                table.search('').draw();
            } else {
                table.search(searchValue).draw();
            }
        });
        // Formatting the date
        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = ("0" + date.getDate()).slice(-2);
            let month = date.toLocaleString('en-US', { month: 'long' });
            let year = date.getFullYear();
            let hours = ("0" + date.getHours()).slice(-2);
            let minutes = ("0" + date.getMinutes()).slice(-2);
            return `${day} ${month} ${year} at ${hours}:${minutes}`;
        }
        // Function to view order
        function viewOrder(id){
            $.ajax({
                url: '/fetch/single/order-history/' + id,
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        table.ajax.reload(null, false);
                        $('#orderViewOffcanvas').offcanvas('show');
                        $('.offcanvas-title').text('Order ID: ' + '#' + response.orderData.id);
                        $('.orderTitle').text(response.orderData.service_title);
                        // Order Inputes
                        let orderInputs = response.orderInputs;
                        let fieldsData = '';
                        let servicePrice = parseFloat(response.orderData.service_price).toFixed(2);
                        let submittedOn = formatDate(response.orderData.created_at);
                        let repliedOn = 'N/A';
                        let repliedIn = 'N/A';
                        let statusClass = '';
                        let processType = response.orderData.process_type === 'Manual' ? 'Admin' : response.orderData.process_type;
                        if (orderInputs.length > 0) {
                            orderInputs.forEach(function(input) {
                                fieldsData += `
                                    <div class="d-flex">
                                        <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">${input.field_name}</div>
                                        <div class="o-history-sec1 border-top pt-2 pb-2 text-break" style="width: calc(100% - 120px);">${input.field_value}</div>
                                    </div>
                                `;
                            });
                        }
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Amount</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${'{{ $currency->icon }}' + servicePrice}</div>
                            </div>
                        `;
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Gateway</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${response.orderData.payment_methode}</div>
                            </div>
                        `;
                        if (response.orderData.trx_id && response.orderData.trx_id !== '-') {
                            fieldsData += `
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">TRX ID</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${response.orderData.trx_id}</div>
                                </div>
                            `;
                        }
                        if (response.orderData.service_status !== 'Waiting Action' && response.orderData.service_status !== 'In Process') {
                            repliedOn = formatDate(response.orderData.updated_at);
                        }
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Submitted on</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${submittedOn}</div>
                            </div>
                        `;
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Replied on</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${repliedOn}</div>
                            </div>
                        `;
                        if(response.orderData.replied_in){
                            fieldsData += `
                                <div class="d-flex">
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Replied in</div>
                                    <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${response.orderData.replied_in}</div>
                                </div>
                            `;
                        }
                        switch (response.orderData.service_status) {
                            case 'Waiting Action':
                                statusClass = 'badge bg-light-secondary';
                                statusIcon = '<i class="fas fa-hourglass-half"></i>';
                                break;
                            case 'In Process':
                                statusClass = 'badge bg-light-warning';
                                statusIcon = '<i class="fas fa-clock"></i>';
                                break;
                            case 'Success':
                                statusClass = 'badge bg-light-success';
                                statusIcon = '<i class="fas fa-check-circle"></i>';
                                break;
                            case 'Rejected':
                                statusClass = 'badge bg-light-danger';
                                statusIcon = '<i class="fas fa-ban"></i>';
                                break;
                            default:
                                statusClass = 'badge bg-secondary';
                        }
                        // Process By
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Process By</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">${processType}</div>
                            </div>
                        `;
                        fieldsData += `
                            <div class="d-flex">
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: 120px;">Order Status</div>
                                <div class="o-history-sec1 border-top pt-2 pb-2" style="width: calc(100% - 120px);">
                                    <span class="${statusClass} fs-6">${statusIcon + ' ' + response.orderData.service_status}</span>
                                </div>
                            </div>
                        `;
                        $('.orderInputs').html(fieldsData);
                        // Service Comments
                        if(response.orderData.service_comments){
                            let commentsData =  `
                                <div class="orderComments fs-5 pb-3 display-1 text-uppercase fw-medium">Comments</div>
                                <div class="service-comments">${response.orderData.service_comments}</div>
                            `;
                            $('.service-comments-info').html(commentsData);
                        } else {
                            $('.service-comments-info').html('');
                        }
                    }
                    else{
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#response').html('<p>An error occurred while uploading the service.</p>');
                }
            });
        }
    });
</script>
@endsection
