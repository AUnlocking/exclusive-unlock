@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Build-in API</h5>
                    <div class="d-flex gap-1">
                        <input type="search" class="form-control py-2" id="api-search" placeholder="Search" />
                    </div>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="api-details" aria-labelledby="announcementLabel" style="width: 1200px"></div>
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
            $('#api-details').on('hide.bs.offcanvas', function () {
                $('.api-data').empty();
            });
            $('#addService').on('hidden.bs.modal', function () {
                $('#add-service-form')[0].reset();
            });
        });

        // Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: false,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_buildin_api') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
            },
            columns: [
                { data: 'api_name', title: 'API NAME', className: 'text-left', orderable: true, searchable: true },
                { data: 'api_url', title: 'API URL', className: 'text-left', orderable: true, searchable: true },
                {   data: 'status',
                    title: '<span style="float:right">STATUS</span>',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'active') {
                            return '<span class="badge bg-light-success fs-6 float-end">Active</span>';
                        } else if (data === 'inactive') {
                            return '<span class="badge bg-light-danger fs-6 float-end">Inactive</span>';
                        }
                        return '<span class="badge bg-light-danger fs-6 float-end">Inactive</span>';
                    }
                },
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
            // Show offcanvas
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadApiDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.card-header h5').text('Build-in API - ' + totalEntries);
                $('#buildinApiCount').text(totalEntries);
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });
        // Function to reload DataTable
        function reloadDataTable() {
            table.ajax.reload(null, false);
        }
        $('#api-search').on('input', function() {
            var searchValue = this.value;
            if (searchValue.length === 0) {
                table.search('').draw();
            } else {
                table.search(searchValue).draw();
            }
        });
        // Add Custom Paginate for service data table
        $('.ser-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.ser-page-next').on('click', function() {
            table.page('next').draw('page');
        });
        // Show offcanvas with order data
        function loadApiDetails(apiID) {
            $.ajax({
                url: '/admin/fetch/api-data/' + apiID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    // Prepare the details HTML
                    $('#api-details').offcanvas('show');
                    let detailsHtml = `
                        <div class="offcanvas-header bg-light-primary">
                            <h5 class="offcanvas-title" id="announcementLabel">${response.api.api_name}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" style="padding:0">
                            <div class="d-block d-md-flex">
                                <div class="customer-m-menu" id="menu">
                                    <button type="button" data-section="api" class="active btn rounded-0"><span>API Info</span></button>
                                    <button type="button" data-section="pricing" class="btn rounded-0"><span>Pricing</span></button>
                                    <button type="button" data-section="services" class="btn rounded-0"><span>Services</span></button>
                                </div>
                                <div class="customer-m-menu-content" id="content">
                                    <div id="api" class="section">
                                        <form id="api-form">
                                            <input type="hidden" name="api_id" id="api_id" value="${apiID}" />
                                            <div class="row mb-3 api_username" style="display:none">
                                                <label for="api_username" class="col-sm-4 col-form-label">API Username</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="api_username" placeholder="API Username" />
                                                </div>
                                            </div>
                                            <div class="row mb-3 api_key" style="display:none">
                                                <label for="api_key" class="col-sm-4 col-form-label">API Access Key</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="api_key" placeholder="API Access Key" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="status" class="col-sm-4 col-form-label">API Status</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" id="api_status" required>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
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
                                    <div id="pricing" class="section" style="display: none;">
                                        <form id="price-type-update-form">
                                            <div class="row  mb-4 pb-4 border-bottom">
                                                <label for="price_type" class="col-sm-4 col-form-label">Pricing Type</label>
                                                <div class="col-sm-8">
                                                    <select name="" class="form-control" id="price_type">
                                                        <option value="fixed_profit">Fixed Profit</option>
                                                        <option value="percentage_base">Percentage Profit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="customer_price" class="col-sm-4 col-form-label">Customer <span class="price_tag"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="customer_price" placeholder="Price" />
                                                        <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="reseller_price" class="col-sm-4 col-form-label">Reseller <span class="price_tag"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="reseller_price" placeholder="Price" />
                                                        <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="distributor_price" class="col-sm-4 col-form-label">Distributor <span class="price_tag"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="distributor_price" placeholder="Price" />
                                                        <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="webowner_price" class="col-sm-4 col-form-label">Web Owner <span class="price_tag"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="webowner_price" placeholder="Price" />
                                                        <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-end">
                                                <button id="priceUpdateBtn" class="btn btn-primary rounded" type="submit">
                                                    <i class="fas fa-check-circle"></i> Upadte
                                                    <span id="priceUpdateLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="services" class="section" style="display: none;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card table-card">
                                                    <div class="card-header py-3" style="border-bottom: 1px solid #dddddd;">
                                                        <div class="d-sm-flex align-items-center gap-2">
                                                            <button type="button" class="btn btn-primary rounded mb-2" id="sync-btn">Synchronize API</button>
                                                            <button class="btn btn-primary rounded mb-2" id="loader-syncbutton" type="button" style="display: none;" disabled>
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                Synchronizing...
                                                            </button>

                                                            <button id="addApiServiceBtn" class="btn btn-primary rounded mb-2" disabled>
                                                                Add Service
                                                                <span id="addApiServiceLoader" class="spinner-border spinner-border-sm text-light" style="display: none;"></span>
                                                            </button>

                                                            <div class="ms-auto mb-2">
                                                                <input type="search" class="form-control py-2" id="service-search" placeholder="Search..." />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body pb-0">
                                                        <div class="table-responsive ">
                                                            <table id="service-data-table" class="display px-5">
                                                                <thead style="border-bottom: 1px solid #dddddd">
                                                                    <tr style="padding:8px 0">
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer" style="padding: 12px 18px">
                                                       <input type="checkbox" id="select-all2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    `;
                    // Inject the HTML into the container
                    $('#api-details').html(detailsHtml);
                    $('#api_name').val(response.api.api_name || '');
                    $('#api_type').val(response.api.api_type || '');
                    $('#api_url').val(response.api.api_url || '');
                    $('#api_username').val(response.api.api_username || '');
                    $('#api_key').val(response.api.api_key || '');
                    $('#api_status').val(response.api.status || '');
                    $('#price_type').val(response.api.price_type || '');
                    $('#customer_price').val(response.api.customer_price || '');
                    $('#reseller_price').val(response.api.reseller_price || '');
                    $('#distributor_price').val(response.api.distributor_price || '');
                    $('#webowner_price').val(response.api.webowner_price || '');
                    priceType(response.api.price_type);
                    // Chimera API
                    if(response.api.api_name == 'Chimera Tool'){
                        $('.api_username').show();
                        $('.api_key').show();
                    }
                    // ON CHANGE PRICING TYPE
                    $('#price_type').on('change', function(){
                        var type = $(this).val();
                        priceType(type);
                        $('#customer_price').val('')
                        $('#reseller_price').val('')
                        $('#distributor_price').val('')
                        $('#webowner_price').val('')
                    })
                    // PRICE TYPE PROCESS
                    function priceType(type){
                        if(type == 'fixed_profit'){
                            $('.price_tag').text('Profit');
                            $('.price_icon').text('$');
                        }
                        else{
                            $('.price_tag').text('Percentage');
                            $('.price_icon').text('%');
                        }
                    }
                    // ONLY NUMERIC ACCEPTED
                    $('#customer_price, #reseller_price, #distributor_price, #webowner_price, #base_price').on('input', function() {
                        this.value = this.value.replace(/[^0-9.]/g, '');
                        if ((this.value.match(/\./g) || []).length > 1) {
                            this.value = this.value.replace(/\.(?=.*\.)/, '');
                        }
                        if (this.value.length > 8) {
                            this.value = this.value.slice(0, 8);
                        }
                    });

                    // MENU
                    initMenu();

                    // API UPDATE - FORM SUBMIT
                    $('#api-form').on('submit', function(event) {
                        event.preventDefault();
                        const formData = {
                            apiUsername: $('#api_username').val(),
                            apiKey: $('#api_key').val(),
                            apiStatus: $('#api_status').val(),
                        };
                        $.ajax({
                            url: '/admin/update/build-in-api/' + apiID,
                            method: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#update-button').hide();
                                $('#loader-button').show();
                            },
                            complete: function() {
                                $('#update-button').show();
                                $('#loader-button').hide();
                            },
                            success: function(response) {
                                if(response.success){
                                    notifier.show('SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                                    loadApiDetails(apiID);
                                    reloadDataTable();
                                }
                                else{
                                    notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                }
                            },
                            error: function(xhr, status, error) {
                                notifier.show('ERROR', 'Error updating API: ' + error, 'danger', '/resource/high_priority-48.png', 10000);
                            },
                        });
                    });

                    // PRICE TYPE UPDATE - FORM SUBMIT
                    $('#price-type-update-form').on('submit', function(event) {
                        event.preventDefault();
                        const formData = {
                            priceType: $('#price_type').val(),
                            customerPrice: $('#customer_price').val(),
                            resellerPrice: $('#reseller_price').val(),
                            distributorPrice: $('#distributor_price').val(),
                            webOwnerPrice: $('#webowner_price').val(),
                        };
                        $.ajax({
                            url: '/admin/update/api-pricing/' + apiID,
                            method: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#priceUpdateBtn').prop('disabled', true);
                                $('#priceUpdateLoader').show();
                            },
                            complete: function() {
                                $('#priceUpdateBtn').prop('disabled', false);
                                $('#priceUpdateLoader').hide();
                            },
                            success: function(response) {
                                if(response.success){
                                    notifier.show('SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                                }
                                else{
                                    notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                }
                            },
                            error: function(xhr, status, error) {
                                notifier.show('ERROR', 'Error updating API: ' + error, 'danger', '/resource/high_priority-48.png', 10000);
                            },
                        });
                    });
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Error loading details: ' + error, 'danger', '/resource/high_priority-48.png', 10000);
                },
            });
        }
        // MENU FUNCTION INITIALIZE
        function initMenu() {
            $('.section').hide();
            $('#api').show();
            $('#menu button').on('click', function() {
                const section = $(this).data('section');
                $('.section').hide();
                $('#menu button').removeClass('active');
                $(this).addClass('active');
                $('#' + section).show();
                // If "custom-price" is selected, fetch custom price data
                if (section === 'services') {fetchRemoteService($('#api_id').val());}
                if (section === 'delapi') {deleteAPI($('#api_id').val());}
            });
        }
        // MENU - REMOTE SERVICE LIST
        function fetchRemoteService(apiID) {
            // Destroy any existing DataTable before initializing a new one
            if ($.fn.dataTable.isDataTable('#service-data-table')) {
                $('#service-data-table').DataTable().clear().destroy();
            }
            $('#service-data-table').empty();
            var table = $('#service-data-table').DataTable({
                processing: false,
                serverSide: true,
                lengthChange: false,
                info: false,
                footer: false,
                ajax: {
                    url: '/admin/fetch/remote-service/' + apiID,
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
                        data: null,
                        title: '<input type="checkbox" id="select-all">',
                        className: 'text-left check-box',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" data-id="${row.id}" >`;
                        }
                    },
                    {
                        data: 'added',
                        title: 'ADDED',
                        className: 'text-left',
                        orderable: false,
                        render: function(data, type, row) {
                            return data === 'yes'
                                ? '<span class="badge bg-light-success"><i class="fas fa-check"></i> Yes</span>'
                                : '<span class="badge bg-light-danger"><i class="fas fa-plus"></i> Add</span>';
                        }
                    },
                    { data: 'SERVICETYPE', title: 'TYPE', className: 'text-left', orderable: false },
                    { data: 'CREDIT', title: 'PRICE', className: 'text-left', orderable: false },
                    { data: 'SERVICENAME', title: 'SERVICE NAME', className: 'text-left', orderable: false },
                ],
                pageLength: -1,
                language: {
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var totalRecords = api.page.info().recordsTotal;
                    if (totalRecords === 0) {
                        $('#service-data-table_paginate').hide();
                        $('#service-data-table_info').hide();
                    } else {
                        $('#service-data-table_paginate').show();
                        $('#service-data-table_info').show();
                    }
                    $('.dataTables_wrapper .dataTables_paginate').hide();
                }
            });
            // Data Table Search
            $('#service-search').on('input', function() {
                var searchValue = this.value;
                if (searchValue.length === 0) {
                    table.search('').draw();
                } else {
                    table.search(searchValue).draw();
                }
            });

            // Data Table "Select" checkbox
            $('#select-all, #select-all2').on('click', function () {
                var isChecked = $(this).prop('checked');
                $('.row-checkbox').prop('checked', isChecked);
                $('#select-all, #select-all2').prop('checked', isChecked);
                updateRowBackground();
                toggleButtonState(); // Ensure button is updated when "Select All" is clicked
            });
            // Listen for changes in individual checkboxes
            $('#service-data-table tbody').on('change', '.row-checkbox', function () {
                var selectedCount = $('.row-checkbox:checked').length;
                var totalRows = $('.row-checkbox').length;
                // Sync "Select All" checkboxes
                $('#select-all, #select-all2').prop('checked', selectedCount === totalRows);
                toggleButtonState(); // Call function to enable/disable button
                updateRowBackground();
            });
            // Function to enable/disable the button
            function toggleButtonState() {
                var selectedCount = $('.row-checkbox:checked').length;
                if (selectedCount > 0) {
                    $('#addApiServiceBtn').prop('disabled', false).addClass('addServices');
                } else {
                    $('#addApiServiceBtn').prop('disabled', true).removeClass('addServices');
                }
                // Add service BTN
                $('.addServices').off('click').on('click', function() {
                    addServices(apiID);
                });
            }
            function updateRowBackground() {
                $('.row-checkbox:checked').each(function() {
                    $(this).closest('tr').addClass('bg-light');
                });
                $('.row-checkbox:not(:checked)').each(function() {
                    $(this).closest('tr').removeClass('bg-light');
                });
            }
            // Disable Add Service BTN
            $('#addApiServiceBtn').prop('disabled', true);
            // Remome selected
            $('#select-all, #select-all2').prop('checked', false);
            // Data Table Sync API BTN
            $('#sync-btn').off('click').on('click', function() {
                syncronizeAPI(apiID);
            });

        }
        // Syncronize API
        function syncronizeAPI(apiID) {
            $.ajax({
                url: '/admin/build-in-api/sync/' + apiID,
                type: 'GET',
                beforeSend: function() {
                    $('#sync-btn').hide();
                    $('#loader-syncbutton').show();
                    $('.top-loader').show();
                },
                complete: function() {
                    $('#sync-btn').show();
                    $('#loader-syncbutton').hide();
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        reloadDataTable();
                        $('#service-data-table').DataTable().ajax.reload(null, false);
                        $('#select-all, #select-all2').prop('checked', false);
                        notifier.show('SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                    }
                    else{
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                },
            });
        }
        // Add Services
        function addServices(apiID) {
            var serviceID = [];
            // Get checked checkboxes
            $('.row-checkbox:checked').each(function() {
                var rowId = $(this).data('id');
                if (rowId !== undefined && rowId !== null) {
                    serviceID.push(rowId);
                }
            });
            // Check if there are selected services
            if (serviceID.length === 0) {
                alert("Please select at least one service to add.");
                return;
            }
            $.ajax({
                url: '{{ route("add_service") }}',
                type: 'POST',
                data: JSON.stringify({ apiID: apiID, serviceID: serviceID }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#addApiServiceBtn').prop('disabled', true);
                    $('#addApiServiceLoader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#addApiServiceLoader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        notifier.show('SUCCESS', response.message, 'success', '/resource/ok-48.png', 10000);
                        reloadDataTable();
                        $('#service-data-table').DataTable().ajax.reload(null, false);
                        $('#addApiServiceBtn').prop('disabled', true);
                        $('#select-all, #select-all2').prop('checked', false);
                    } else {
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                        $('#addApiServiceBtn').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                    $('#addApiServiceBtn').prop('disabled', false);
                }
            });
        }


    })
</script>
@endsection
