@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Success</h5>
                    <div>
                        <input type="search" class="form-control py-2" id="order-search" placeholder="Search order..." />
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="order-details" aria-labelledby="announcementLabel" style="width: 500px"></div>
{{-- Modal --}}
<div class="modal fade modal-animate" id="set-back-rejected" tabindex="-1" aria-labelledby="setBackRejectedLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setBackRejectedLabel">Are you sure to set back as Rejected?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" id="confirm-reject-btn"><i class="fas fa-ban"></i> Set back Rejected</button>
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
        // Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('table_order_success') }}',
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
                    className: 'text-left order-id',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return `<span class="table-id">${data}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    title: 'DATE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data) {
                            const date = new Date(data);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
                            const year = date.getFullYear();
                            return `${day}-${month}-${year}`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'service_title',
                    title: 'SERVICE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function (data) {
                        if (data && data.length > 60) {
                            return `<span data-toggle="tooltip" title="${data}">${data.substring(0, 60)}...</span>`;
                        } else {
                            return `<span data-toggle="tooltip" title="${data}">${data}</span>`;
                        }
                    },
                    createdCell: function (td) {
                        $(td).tooltip();
                    }
                },
                {
                    data: 'service_input1',
                    title: 'INPUT',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data !== null && data !== undefined) {
                            const shortText = data.length > 15 ? data.substring(0, 15) + '...' : data;
                            return `<span data-toggle="tooltip" title="${data}">${shortText}</span>`;
                        } else {
                            return '-';
                        }
                    },
                    createdCell: function(td) {
                        $(td).tooltip();
                    }
                },
                {
                    data: 'customer_name',
                    title: 'CUSTOMER',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data !== null && data !== undefined) {
                            const shortText = data.length > 15 ? data.substring(0, 15) + '...' : data;
                            return `<span data-toggle="tooltip" title="${data}">${shortText}</span>`;
                        } else {
                            return '-';
                        }
                    },
                    createdCell: function(td) {
                        $(td).tooltip();
                    }
                },
                { data: 'payment_methode', title: 'GATEWAY', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'service_price',
                    title: 'AMOUNT',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        const currencyIcon = row.currency_icon || '';
                        const currency = row.currency || '';
                        return data !== null && data !== undefined
                        ? `${currencyIcon}${data} (${currency})`
                        : '-';
                    }
                },
                {
                    data: 'service_status',
                    title: 'STATUS',
                    className: 'order-status',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return `<span class="badge bg-light-success fs-6" style="float:right">${'<i class="fas fa-clock"></i> ' + data}</span>`;
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
            // Show offcanvas
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadOrderDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal; // Get the total number of entries
                $('.card-header h5').text('Success - ' + totalEntries);
                $('#successCount').text(totalEntries);
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });
        $('#order-search').on('input', function() {
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
        });
        // Show offcanvas with order data
        function loadOrderDetails(orderId) {
            $.ajax({
                url: '/admin/get/order/details/' + orderId,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    // Helper function to format the date
                    $('#order-details').offcanvas('show');
                    function formatDate(dateString) {
                        const date = new Date(dateString);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}-${month}-${year}`;
                    }
                    const formattedCreatedDate = formatDate(response.order.created_at);
                    const formattedUpdatedDate = formatDate(response.order.updated_at);
                    let detailsHtml = `
                        <div class="offcanvas-header" style="background: #c8d5f6; border-bottom: 1px solid #145ddd24">
                            <h5 class="offcanvas-title" id="announcementLabel">Order ID: ${response.order.id}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div style="border-bottom: 1px solid #e7e7e7; padding: 10px 0 15px 0">
                                <strong>${response.order.service_title}</strong>
                                <div style="padding: 10px 0">${response.order.order_inputs.map(input => `${input.field_name}: ${input.field_value}`).join('<br />')}</div>
                            </div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Cust. Name</span> <span class="offcanvas-order-details-list-2">${response.order.customer ? response.order.customer.name : '-'}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Cust. Email</span> <span class="offcanvas-order-details-list-2">${response.order.customer ? response.order.customer.email : '-'}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Getwaye</span> <span class="offcanvas-order-details-list-2">${response.order.payment_methode + ' - ' + response.order.trx_id}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Price</span> <span class="offcanvas-order-details-list-2">${response.order.service_price}$</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Qnt</span> <span class="offcanvas-order-details-list-2">${response.order.service_qnt}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Order</span> <span class="offcanvas-order-details-list-2">${formattedCreatedDate}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Replied</span> <span class="offcanvas-order-details-list-2">${formattedUpdatedDate}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Process</span> <span class="offcanvas-order-details-list-2">${response.orderProcess}</span></div>
                            <div class="offcanvas-order-details-list"><span class="offcanvas-order-details-list-1">Status</span> <span class="offcanvas-order-details-list-2"><span class="badge bg-light-success fs-6">${'<i class="fas fa-check-circle"></i> ' + response.order.service_status}</span></span></div>
                            <div class="offcanvas-order-details-list order-comments">
                                <span class="offcanvas-comments" id="order-comments">${response.order.service_comments}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light-danger rounded-0" id="rejectButton">Set it back as rejected</button>
                    `;
                    $('#order-details').html(detailsHtml);
                    // Attach copy button functionality
                    $('.order-comments').on('click', function() {
                        const comments = $('#order-comments').text();
                        navigator.clipboard.writeText(comments).then(() => {
                            alert('Copied to clipboard!');
                        }).catch(err => {
                            console.error('Error copying text: ', err);
                        });
                    });
                },
                error: function(xhr, status, error) {
                    $('#order-details .offcanvas-body').html('<p>Error loading details. Please try again.</p>');
                },
            });
        }

        // Set back Rejected + Modal Confirmation
        $(document).on('click', '#rejectButton', function() {
            const orderId = $('#order-details .offcanvas-title').text().split(': ')[1];

            $(this).hide(); // Hide the Set back Reject button
            const loadingSpinner = `
                <button class="btn btn-light-danger rounded-0" id="loadingSpinner" type="button" disabled style="background: #fce9e9; color:#dc2626; border:0;" >
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Loading...
                </button>
            `;
            $('#order-details').append(loadingSpinner); // show loader Set back Reject button


            $.ajax({
                url: '/admin/get/order/details/' + orderId,
                method: 'GET',
                success: function(response) {
                    const serviceTitle = response.order.service_title;
                    const orderInputs = response.order.order_inputs.map(input => `${input.field_name}: ${input.field_value}`).join('<br />');

                    $('#set-back-rejected .modal-body').html(`
                        <div style="margin-bottom:10px">${serviceTitle}</div>
                        ${orderInputs}
                    `);

                    $('#order-details').offcanvas('hide'); // hide offcanvas
                    $('#set-back-rejected').modal('show'); // show modal

                    $('#confirm-reject-btn').off('click').on('click', function() {
                        $(this).hide(); // hide the reject button on modal
                        const loadingButton = `
                            <button class="btn btn-light-danger lh-1" type="button" style="background: #dc2626; color:white;">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Loading...
                            </button>
                        `;
                        $('#set-back-rejected .modal-footer').append(loadingButton); // show the loader on reject button
                        // attempt to update order status
                        $.ajax({
                            url: '/admin/set-back-rejected/' + orderId,
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                status: 'Rejected',
                                serviceComments: response.order.service_comments,
                            }),
                            success: function(response) {
                                table.ajax.reload();
                                $('#set-back-rejected').modal('hide'); // after update order, hide modal
                            },
                            error: function(xhr, status, error) {
                                $('#set-back-rejected .modal-footer .btn-light-danger.lh-1').remove(); // remove loader on modal
                                $('#confirm-reject-btn').show(); // show reject button on modal
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessages = [];
                                    for (let field in xhr.responseJSON.errors) {
                                        if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                                            errorMessages = errorMessages.concat(xhr.responseJSON.errors[field]);
                                        }
                                    }
                                    alert("Error:\n" + errorMessages.join('\n'));
                                } else {
                                    alert("Error: " + xhr.responseJSON.message || "An unknown error occurred.");
                                }
                            },
                            complete: function() {
                                // Ensure loading button is removed on success too
                                $('#set-back-rejected .modal-footer .btn-light-danger.lh-1').remove(); // remove loader on modal
                                $('#confirm-reject-btn').show(); // show reject button on modal
                            }
                        });
                    });

                },
                error: function(xhr, status, error) {
                    alert("There was an error fetching the order details: " + xhr.responseJSON.message);
                },
                complete: function() {
                    $('#loadingSpinner').remove(); // remove loader on offcanvas set back reject button
                    $('#rejectButton').show(); // show set back reject button on offcanvas
                }
            });
        });


    });
    </script>

@endsection
