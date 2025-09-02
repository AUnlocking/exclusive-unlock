@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header service-card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Digital Inventory</h5>
                    <div class="d-flex gap-2">
                        <input type="search" class="form-control py-2" id="service-search" placeholder="Search"  />
                        <button type="button" class="btn btn-light-primary border-primary rounded py-2" data-bs-toggle="modal" data-bs-target="#addNewInventory"><i class="fas fa-plus"></i></button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="inventory-details" aria-labelledby="servicedetailsLabel" style="width: 850px">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="announcementLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <input type="hidden" id="inventoryId" name="inventoryId">
        <div class="card-header pb-0">
            <ul class="nav nav-tabs analytics-tab border-bottom" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active m-0" id="available-tab" data-bs-toggle="tab" data-bs-target="#available-tab-pane" type="button" role="tab" aria-controls="available-tab-pane" aria-selected="true" >API</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="soldout-tab" data-bs-toggle="tab" data-bs-target="#soldout-tab-pane" type="button" role="tab" aria-controls="soldout-tab-pane" aria-selected="true">Inventory</button>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="available-tab-pane" role="tabpanel" aria-labelledby="available-tab" tabindex="0">
                <ul class="list-group list-group-flush mt-3" id="available-code"></ul>
            </div>
            <div class="tab-pane fade" id="soldout-tab-pane" role="tabpanel" aria-labelledby="soldout-tab-label" tabindex="0">
                <ul class="list-group list-group-flush mt-3" id="soldout-code"></ul>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="d-flex">
            <button type="button" class="btn btn-success rounded-0 w-100 " data-bs-toggle="modal" data-bs-target="#addNewCode">
                <i class="fas fa-plus"></i> Add Code
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
            <button type="button" class="btn btn-info rounded-0 w-100 " data-bs-toggle="modal" data-bs-target="#updateInventory">
                <i class="fas fa-pencil-alt"></i> Edit
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
            <button type="button" class="btn btn-danger rounded-0 w-100 del-inventory">
                <i class="fas fa-trash-alt"></i> Delete
                <span class="spinner-border spinner-border-sm d-none" id="delLoadingSpinner" role="status"></span>
            </button>
        </div>
    </div>
</div>
{{-- Add New Inventory - Modal --}}
<div class="modal fade modal-animate" id="addNewInventory" tabindex="-1" aria-labelledby="addNewInventory" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="new-inventory-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewInventoryLabel">Add new inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="new-inventory-name" class="col-sm-4 col-form-label">Inventory Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="new-inventory-name" placeholder="Inventory Name" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="new-update-button" type="submit">
                        <i class="fas fa-check-circle"></i> Add
                    </button>
                    <button class="btn btn-primary" id="new-loader-button" type="button" style="display:none" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Update Inventory - Modal --}}
<div class="modal fade modal-animate" id="updateInventory" tabindex="-1" aria-labelledby="updateInventory" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update-inventory-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateInventoryLabel">Update inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="update-inventory-name" class="col-sm-4 col-form-label">Inventory Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="update-inventory-name" placeholder="Inventory Name" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="update-inventory-button" type="submit">
                        <i class="fas fa-check-circle"></i> Update
                    </button>
                    <button class="btn btn-primary" id="update-inventory-loader" type="button" style="display:none" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add New Code - Modal --}}
<div class="modal fade modal-animate" id="addNewCode" tabindex="-1" aria-labelledby="addNewCode" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="add-code-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewCodeLabel">Add Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="new-code" class="col-sm-3 col-form-label">Enter Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-code" placeholder="Enter Code" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="codeFor" class="col-sm-3 col-form-label">Code For</label>
                        <div class="col-sm-9">
                            <input readonly class="form-control" id="codeFor" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="new-code-button" type="submit">
                        <i class="fas fa-check-circle"></i> Add Code
                    </button>
                    <button class="btn btn-primary" id="new-code-loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Update Code - Modal --}}
<div class="modal fade modal-animate" id="viewCode" tabindex="-1" aria-labelledby="viewCode" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update-code-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCodeLabel">Update Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="update-code-data" class="col-sm-3 col-form-label">Enter Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="update-code-data" placeholder="Enter Code" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="mark-as" class="col-sm-3 col-form-label">Mark as</label>
                        <div class="col-sm-9">
                            <select name="" id="mark-as" class="form-control">
                                <option value="Available">Available</option>
                                <option value="Sold out">Sold out</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="code-id" name="code-id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="update-code-button" type="submit">
                        <i class="fas fa-check-circle"></i> Update
                    </button>
                    <button class="btn btn-primary" id="update-code-loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
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
        // Service List - Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: false,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fectch_inventory') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
            },
            columns: [
                { data: 'name', title: 'INVENTORY NAME', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'available_code',
                    title: 'Available',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data + ' code available' ;
                    }
                },
                {
                    data: 'available_code',
                    title: 'Status',
                    className: 'text-end',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data > 0) {
                            return '<span class="badge bg-light-success fs-6">Active</span>';
                        } else {
                            return '<span class="badge bg-light-danger fs-6">Inactive</span>';
                        }

                    }
                },
            ],
            order: [[0, 'asc']],
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
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function(event) {
                    loadServiceDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.card-header h5').text('Digital Inventory - ' + totalEntries);
                $('#credit-count').text(totalEntries);
                $('.dataTables_wrapper .dataTables_paginate').hide();
                $('.dataTables_scrollBody').css('border-bottom', '0');
            }
        });
        // Add Custom Paginate for service data table
        $('.ser-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.ser-page-next').on('click', function() {
            table.page('next').draw('page');
        });
        // Seraching - Service datat table
        $('#service-search').on('input', function() {
            var searchValue = this.value;
            if (searchValue.length === 0) {
                table.search('').draw();
            } else {
                table.search(searchValue).draw();
            }
        });
        // Function to reload Service DataTable
        function reloadDataTable() {
            table.ajax.reload(null, false);
        }
        // Show offcanvas with service data
        function loadServiceDetails(inventoryID) {
            $.ajax({
                url: '/admin/load/inventory/' + inventoryID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('#inventory-details').offcanvas('show');
                        $('.offcanvas-title').text(response.inventory.name);
                        $('#inventoryId').val(response.inventory.id);
                        $('#update-inventory-name').val(response.inventory.name);
                        $('#codeFor').val(response.inventory.name);
                        $('#available-tab').text('Available Code (' + response.availableCount + ')');
                        $('#soldout-tab').text('Sold Out Code (' + response.soldOutCount + ')');
                        $('#available-code').empty();
                        response.availableCode.forEach(function(code, index) {
                            var availableItem = `
                                <div class="inventory-content d-flex gap border-bottom pb-3 mb-3">
                                    <div>${index + 1}. ${code.code}</div>
                                    <div class="ms-auto d-flex gap-1">
                                        <span class="badge text-bg-success view-code" style="cursor: pointer" data-id="${code.id}"> <i class="fas fa-pencil-alt"></i> </span>
                                        <span class="badge text-bg-danger del-code" style="cursor: pointer" data-id="${code.id}" data-code="${code.code}"> <i class="fas fa-trash-alt"></i> </span>
                                    </div>
                                </div>
                            `;
                            $('#available-code').append(availableItem);
                        });
                        $('#soldout-code').empty();
                        response.soldOutCode.forEach(function(code, index) {
                            var soldoutItem = `
                                <div class="inventory-content d-flex gap border-bottom pb-3 mb-3 text-danger">
                                    <div>${index + 1}. ${code.code}</div>
                                    <div class="ms-auto d-flex gap-1">
                                        <span class="badge text-bg-success view-code" style="cursor: pointer" data-id="${code.id}"> <i class="fas fa-pencil-alt"></i> </span>
                                        <span class="badge text-bg-danger del-code" style="cursor: pointer" data-id="${code.id}" data-code="${code.code}"> <i class="fas fa-trash-alt"></i> </span>
                                    </div>
                                </div>
                            `;
                            $('#soldout-code').append(soldoutItem);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error loading details: ' + error);
                },
            });
        }
        // START - ADD NEW INVENTORY
        $(document).ready(function() {
            $('#new-inventory-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    inventoryName: $('#new-inventory-name').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: '{{ route('add_inventory') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#new-update-button').hide();
                        $('#new-loader-button').show();
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('#new-update-button').show();
                        $('#new-loader-button').hide();
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                        if (response.success) {
                            reloadDataTable();
                            $('#addNewInventory').modal('hide');
                            $('#new-inventory-form')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });
        // START - ADD CODE
        $(document).ready(function() {
            $('#add-code-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    Code: $('#new-code').val(),
                    inventoryId: $('#inventoryId').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: '{{ route('add_code') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#new-code-button').hide();
                        $('#new-code-loader').show();
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('#new-code-button').show();
                        $('#new-code-loader').hide();
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                        if (response.success) {
                            loadServiceDetails(formData.inventoryId);
                            reloadDataTable();
                            $('#addNewCode').modal('hide');
                            $('#add-code-form')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });
        // View Code
        $(document).on('click', '.view-code', function() {
            var codeId = $(this).data('id');
            $.ajax({
                url: '/admin/fetch/code-data/' + codeId,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        $('#viewCode').modal('show');
                        $('#update-code-data').val(response.codeData.code);
                        $('#mark-as').val(response.codeData.status);
                        $('#code-id').val(response.codeData.id);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error loading details: ' + error);
                },
            });

        });
        // UPDATE CODE
        $(document).ready(function() {
            $('#update-code-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    upId: $('#code-id').val(),
                    upCode: $('#update-code-data').val(),
                    upStatus: $('#mark-as').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: '{{ route('update_code') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#update-code-button').hide();
                        $('#update-code-loader').show();
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('#update-code-button').show();
                        $('#update-code-loader').hide();
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                        if (response.success) {
                            loadServiceDetails(response.inventoryId);
                            $('#viewCode').modal('hide');
                            $('#update-code-form')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });
        // Delete Code
        $(document).on('click', '.del-code', function() {
            var codeId = $(this).data('id');
            var code = $(this).data('code');
            var userConfirmed = confirm('Are you sure to delete: ' + code + ' ?');
            if(userConfirmed){
                $.ajax({
                    url: '/admin/code/del/' + codeId,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                            loadServiceDetails(response.inventoryId);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading details: ' + error);
                    },
                });
            }
        });
        // Update Inventry Name
        $(document).ready(function() {
            $('#update-inventory-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    upId: $('#inventoryId').val(),
                    upName: $('#update-inventory-name').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: '{{ route('update_inventory') }}',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#update-inventory-button').hide();
                        $('#update-inventory-loader').show();
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('#update-inventory-button').show();
                        $('#update-inventory-loader').hide();
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                        if (response.success) {
                            reloadDataTable();
                            $('#updateInventory').modal('hide');
                            $('#update-inventory-form')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });
        // Delete Inventory
        $(document).on('click', '.del-inventory', function() {
            var inventoryId = $('#inventoryId').val();
            var inventoryName = $('#update-inventory-name').val();
            var userConfirmed = confirm('Are you sure to delete?\n' + 'Inventory: ' + inventoryName + '\nIncluding all inventory data');
            if(userConfirmed){
                $.ajax({
                    url: '/admin/del/inventory/' + inventoryId,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                        $('.del-inventory').attr('disabled', true);
                        $('#delLoadingSpinner').removeClass('d-none');
                    },
                    complete: function() {
                        $('.top-loader').hide();
                        $('#delLoadingSpinner').addClass('d-none');
                        $('.del-inventory i').show();
                        $('.del-inventory').attr('disabled', false);
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
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
                            $('#inventory-details').offcanvas('hide');
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading details: ' + error);
                    },
                });
            }
        });


    })
</script>
@endsection
