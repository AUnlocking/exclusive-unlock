@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">CUSTOMER</h5>
                    <div class="d-flex gap-1">
                        <input type="search" class="form-control py-2" id="customer-search" placeholder="Search" />
                        <button type="button" class="btn btn-light-primary border-primary rounded py-2" data-bs-toggle="modal" data-bs-target="#addNewCustomer"><i class="fas fa-plus"></i></button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="customer-details" aria-labelledby="announcementLabel" style="width: 850px">
    <div class="offcanvas-header bg-light-primary">
        <h5 class="offcanvas-title" id="announcementLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding:0">
        <div class="d-block d-md-flex">
            <div class="customer-m-menu" id="menu">
                <button type="button" data-section="general" class="active btn rounded-0"><span>Profile</span></button>
                <button type="button" data-section="custom-price" class="btn rounded-0"><span>Pricing</span></button>
                <button type="button" data-section="financial" class="btn rounded-0"><span>Financial</span></button>
                <button type="button" data-section="api" class="btn rounded-0"><span>API Access</span></button>
                <button type="button" data-section="statement" class="btn rounded-0 statement-tab"><span>Statement</span></button>
                <button type="button" data-section="service" class="btn rounded-0 service-tab"><span>Service</span></button>
                <button type="button" data-section="account" class="btn rounded-0"><span>Account</span></button>
            </div>
            <div class="customer-m-menu-content" id="content">
                <div id="general" class="section">
                    <form id="customer-form">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" placeholder="Name" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mobile" placeholder="Mobile" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="role" required>
                                    <option value="">--</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Distributor">Distributor</option>
                                    <option value="Web Owner">Web Owner</option>
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
                <div id="custom-price" class="section" style="display: none;">
                    <form id="custom-price-form">
                        <input type="hidden" name="customer_id" id="customer_id" value="${customerId}" />
                        <input type="hidden" name="customer_currency" id="customer_currency" value="${response.customer.currency}" />
                        <input type="hidden" name="customer_balance" id="customer_balance" value="${response.customer.balance}" />
                        <div class="mb-3 d-flex" style="gap:10px">
                            <div style="width:calc(100% - 90px)">
                                <select class="form-control" id="custom-service-list" style="width: 100%" required>
                                    @foreach ($serviceList as $list)
                                    <option value="{{$list->id}}">{{$list->title . ' - ' . $list->original_price}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="width:90px; text-align: center">
                                <button class="btn btn-primary rounded" id="add-custom-price-button" type="submit" style="padding:11px; width:100%">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="custom-list" id="custom-price-list"></div>
                </div>
                <div id="financial" class="section" style="display: none;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0 pt-2">
                                <ul class="nav nav-tabs analytics-tab" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="add-balance-tab" data-bs-toggle="tab" data-bs-target="#add-balance-tab-pane" type="button" role="tab" aria-controls="add-balance-tab-pane" aria-selected="true" >
                                            Add/Remove Balance
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body px-4 py-0">
                                <div class="row">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="add-balance-tab-pane" role="tabpanel" aria-labelledby="add-balance-tab" tabindex="0">
                                            <form id="add-fund-form">
                                                <div class="row py-4">
                                                    <div class="col-md-5">
                                                        <div>
                                                            <input type="hidden" name="type" id="type" value="add">
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter Amount" />
                                                                <button class="btn btn-light-secondary rounded-end border border-secondary" type="button" disabled id="customerCurrency"></button>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button type="submit" class="btn btn-primary rounded w-100" id="fund-submit-btn"><i class="fas fa-check-circle"></i> Update Balance</button>
                                                            <button class="btn btn-primary rounded w-100" id="fund-loader-button" type="button" style="display: none" disabled>
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                Loading...
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 ps-4">
                                                        <div class="border-bottom pb-2">Current Balance <span class="float-end currentAmount">-</span></div>
                                                        <div class="border-bottom py-2">Deposit Amount <span class="float-end depositAmount">-</span></div>
                                                        <div class="border-bottom py-2">Balance After Deposit <span class="float-end balanceAfterDeposit">-</span></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="api" class="section" style="display: none;">
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Api Access</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="apiBtn" style="padding:15px 30px">
                        </div>
                    </div>
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-3 col-form-label">API Access Key</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                <input readonly class="form-control" id="api-access-key" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary generate-api-key" type="button"><i class="fas fa-redo"></i></button>
                                <button class="btn btn-outline-secondary api-access-copy" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px;"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">UserName/Email</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                <input readonly class="form-control" id="api-username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary api-user-copy" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px; width:100px"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">API Url</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                <input readonly class="form-control" id="api-url" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary api-url-copy" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px; width:100px"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Allow IP</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                <input readonly class="form-control" id="api-allow-ip" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary reset-api-ip" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px; width:100px"><i class="fas fa-unlink"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="statement" class="section" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-body pb-0">
                                    <div class="table-responsive ">
                                        <table id="statement-data-table" class="display px-5">
                                            <thead style="border-bottom: 1px solid #dddddd">
                                                <tr style="padding:8px 0">
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer" style="padding: 12px 15px">
                                    <button type="button" class="btn btn-icon btn-primary cus-state-page-prev"><i class="fas fa-angle-left"></i></button>
                                    <button type="button" class="btn btn-icon btn-primary cus-state-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="service" class="section" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card table-card">
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
                                <div class="card-footer" style="padding: 12px 15px">
                                    <button type="button" class="btn btn-icon btn-primary cus-ser-page-prev"><i class="fas fa-angle-left"></i></button>
                                    <button type="button" class="btn btn-icon btn-primary cus-ser-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="account" class="section" style="display: none;">
                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Over Due</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="overdueBtn" style="padding:15px 30px">
                        </div>
                    </div>

                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Account Block</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="blockBtn" style="padding:15px 30px">
                        </div>
                    </div>

                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Google 2FA</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <input class="form-check-input input-primary float-end" type="checkbox" id="2faBtn" style="padding:15px 30px" disabled>
                        </div>
                    </div>

                    <div class="row mb-2 pb-2 border-bottom align-items-center">
                        <label class="col-sm-6 col-form-label" for="">Delete Account</label>
                        <div class="form-check form-switch custom-switch-v1 col-sm-6">
                            <div class="float-end">
                                <button class="btn btn-light-danger" id="delBtn" type="button">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <button class="btn btn-danger" id="delBtnLoader" type="button" style="display: none" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Deleting...
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}
<div class="modal fade modal-animate" id="addNewCustomer" tabindex="-1" aria-labelledby="addNewCustomer" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="new-customer-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewCustomerLabel">Add new customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="new-name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-name" placeholder="Name" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="new-email" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-mobile" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-mobile" placeholder="Mobile" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-password" placeholder="Password" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-currency" class="col-sm-3 col-form-label">Currency</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="new-currency" required >
                                <option value="">--</option>
                                @foreach ($currencyList as $currency)
                                <option value="{{$currency->code}}">{{$currency->code}} - ({{$currency->name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="new-role" required>
                                <option value="">--</option>
                                <option value="Customer">Customer</option>
                                <option value="Reseller">Reseller</option>
                                <option value="Distributor">Distributor</option>
                                <option value="Web Owner">Web Owner</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="new-update-button" type="submit">
                        <i class="fas fa-check-circle"></i> Add
                    </button>
                    <button class="btn btn-primary lh-1" id="new-loader-button" type="button" style="display:none;padding:11px" disabled>
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
        $('div.dataTables_filter').hide();
        // Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '/admin/fetch/customer-list',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                error: function(xhr, error, thrown) {
                    $('.top-loader').hide();
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
                { data: 'id', title: 'ID', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'name',
                    title: 'NAME',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                { data: 'email', title: 'EMAIL', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'mobile',
                    title: 'Mobile',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                { data: 'role', title: 'ROLE', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'balance',
                    title: 'BALANCE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        const balanceValue = parseFloat(data);
                        const currency = row.currency || '';
                        const displayValue = currency + ' ' + balanceValue.toFixed(2);
                        if (balanceValue < 0) {
                            return `<span style="color: red;">${displayValue}</span>`;
                        }
                        return displayValue;
                    }
                },
                {
                    data: 'over_due',
                    title: 'OVERDUE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'allow') {
                            return '<span style="color: red;">Enable</span>';
                        } else {
                            return 'Disable';
                        }
                    }
                },
                {
                    data: 'api_allow',
                    title: 'API',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'on') return 'ON';
                        else if (data === 'off') return 'OFF';
                        else return 'OFF';
                    }
                },
                {
                    data: 'created_at',
                    title: 'CREATED',
                    className: 'text-left',
                    orderable: false,
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
                    data: 'status',
                    title: '<span style="float:right">STATUS</span>',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Verified') return '<span class="badge bg-light-success fs-6" style="float:right">Active</span>';
                        else if (data === 'Block') return '<span class="badge bg-light-danger fs-6" style="float:right">Block</span>';
                    }
                }
            ],
            order: [[0, 'desc']],
            pageLength: 100,
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadCustomerDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.card-header h5').text('CUSTOMER: ' + totalEntries);
                $('#coustomerCount').text(totalEntries);
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
        // IF OFFCANVAS HIDE THEN CLEAR ALL DATA
        $('#customer-details').on('hide.bs.offcanvas', function () {
            initMenu();
            $('#menu button').removeClass('active');
            $('[data-section="general"]').addClass('active');
        });

        // Show offcanvas with Customer data
        function loadCustomerDetails(customerId) {
            $.ajax({
                url: '/admin/fetch/customer/details/' + customerId,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if(response.success){
                        // MENU
                        initMenu();
                        $('#customer-details').offcanvas('hide');
                        $('#customer-details').offcanvas('show');
                        $('.offcanvas-title').text(response.customer.name + ' (' + parseFloat(response.customer.balance).toFixed(2) + ' ' + response.customer.currency + ')');
                        $('#name').val(response.customer.name || '');
                        $('#mobile').val(response.customer.mobile || '');
                        $('#role').val(response.customer.role || '');
                        $('#customerCurrency').text(response.customer.currency || '');
                        $('#apiBtn').prop('checked', response.customer.api_allow == 'on');
                        $('#api-access-key').val(response.customer.api_key || '');
                        $('#api-username').val(response.customer.email || '');
                        $('#api-url').val("{{route('home')}}/public");
                        $('#api-allow-ip').val(response.customer.api_ip || '');
                        $('#overdueBtn').prop('checked', response.customer.over_due == 'allow');
                        $('#blockBtn').prop('checked', response.customer.status === 'Block');

                        $('#2faBtn').prop('checked', response.customer.google2fa_enabled);
                        if (response.customer.google2fa_enabled) {
                            $('#2faBtn').prop('disabled', false);
                        } else {
                            $('#2faBtn').prop('disabled', true);
                        }

                        const priceTypeMap = {
                            percentage_base: "Percentage - Auto Update: Yes",
                            fixed_price: "Fixed Price - Auto Update: No",
                            fixed_profit: "Fixed Profit - Auto Update: Yes"
                        };

                        const customPriceListHtml = response.custom_list.map(item => {
                            const serviceTitle = item.service?.title || "Unknown Service"; // Safe fallback
                            return `
                                <div class="customer-custom-price-list" data-id="${item.id}">
                                    <div class="customer-custom-price-list-sec-1">${serviceTitle}</div>
                                    <div class="customer-custom-price-list-sec-2">
                                        <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                            <input type="number" class="form-control py-0" value="${item.profit_amount ?? 0}" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-secondary save-button" type="button"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-outline-secondary delete-button" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                        <small class="text-muted">${priceTypeMap[item.service?.price_type] || "Unknown"}</small>
                                    </div>
                                </div>
                            `;
                        }).join('');

                        $('#custom-price-list').html(customPriceListHtml);


                        // Update Customer Profile
                        $('#customer-form').off('submit').on('submit', function(event) {
                            event.preventDefault();
                            const formData = {
                                name: $('#name').val(),
                                mobile: $('#mobile').val(),
                                role: $('#role').val(),
                            };
                            $.ajax({
                                url: '/admin/update/customer/profile/' + customerId,
                                method: 'POST',
                                data: formData,
                                beforeSend: function() {
                                    $('.top-loader').show();
                                    $('#update-button').hide();
                                    $('#loader-button').show();
                                },
                                complete: function() {
                                    $('.top-loader').hide();
                                    $('#update-button').show();
                                    $('#loader-button').hide();
                                },
                                success: function(response) {
                                    if(response.success){
                                        notifier.show('Success', response.message, 'success', '/resource/ok-48.png', 10000);
                                        reloadDataTable();
                                    }
                                    else{
                                        notifier.show('ERROR',  response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    notifier.show('ERROR',  error, 'danger', '/resource/high_priority-48.png', 10000);
                                },
                            });
                        });

                        // Add New Custom Service
                        $('#custom-price-form').off('submit').on('submit', function(event) {
                            event.preventDefault();
                            const formData = {
                                customer_id: customerId,
                                service_id: $('#custom-service-list').val(),
                            };
                            $.ajax({
                                url: '{{route('add_custom_price')}}',
                                method: 'POST',
                                data: formData,
                                beforeSend: function() {
                                    $('.top-loader').show();
                                },
                                complete: function() {
                                    $('.top-loader').hide();
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#custom-price-form')[0].reset();
                                        const newItemHtml = `
                                            <div class="customer-custom-price-list" data-id="${response.itemId}">
                                                <div class="customer-custom-price-list-sec-1">${response.itemTitle}</div>
                                                <div class="customer-custom-price-list-sec-2">
                                                    <div class="input-group mb-3" style="margin-bottom: 0 !important">
                                                        <input type="number" class="form-control py-0" value="${response.itemProfit}" aria-describedby="button-addon2">
                                                        <button class="btn btn-outline-secondary save-button" type="button"><i class="fas fa-check"></i></button>
                                                        <button class="btn btn-outline-secondary delete-button" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                    <small class="text-muted">${response.itemPriceType}</small>
                                                </div>
                                            </div>
                                        `;
                                        $('#custom-price-list').append(newItemHtml);
                                        notifier.show('Success', response.message, 'success', '/resource/ok-48.png', 10000);
                                    } else {
                                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    notifier.show('ERROR', 'Error adding the item', 'danger', '/resource/high_priority-48.png', 10000);
                                }
                            });
                        });

                        // Financial
                        const formattedCurrentBalance = parseFloat(response.customer.balance).toFixed(2);
                        const customerCurrency = response.customer.currency
                        $('.currentAmount').text(formattedCurrentBalance + ' ' + customerCurrency);
                        $('#amount').on('input', function () {
                            let value = $(this).val();
                            value = value.replace(/[^0-9.-]/g, '');
                            if (value.includes('-') && value.indexOf('-') > 0) {
                                value = value.replace('-', '');
                            }
                            const decimalParts = value.split('.');
                            if (decimalParts.length > 2) {
                                value = decimalParts[0] + '.' + decimalParts.slice(1).join('');
                            }
                            if (value.length > 8) {
                                value = value.slice(0, 8);
                            }
                            $(this).val(value);
                            const depositAmount = parseFloat(value) || 0;
                            const formattedDepositAmount = depositAmount.toFixed(2);
                            $('.depositAmount').text(formattedDepositAmount + ' ' + customerCurrency);
                            const balanceAfterDeposit = (parseFloat(formattedCurrentBalance) + depositAmount).toFixed(2);
                            $('.balanceAfterDeposit').text(balanceAfterDeposit + ' ' + customerCurrency);
                        });
                        $('#add-fund-form').off('submit').on('submit', function(event) {
                            event.preventDefault();
                            const amount = $('#amount').val();
                            if (!amount || amount == 0) {
                                notifier.show('ERROR', 'Please enter a valid amount.', 'danger', '/resource/high_priority-48.png', 10000);
                                return;
                            }
                            const formData = {
                                amount: amount,
                                customer_id: customerId
                            };
                            $('#fund-submit-btn').hide();
                            $('#fund-loader-button').show();
                            $.ajax({
                                url: '/admin/add-fund',
                                method: 'POST',
                                data: formData,
                                success: function(response) {
                                    if (response.success) {
                                        notifier.show(response.title, response.message, 'success', '/resource/ok-48.png', 10000);
                                        $('#customer-details').offcanvas('hide');
                                        reloadDataTable();
                                    } else {
                                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    notifier.show('ERROR', 'Error occurred while submitting data.', 'danger', '/resource/high_priority-48.png', 10000);
                                },
                                complete: function() {
                                $('#add-fund-form')[0].reset();
                                $('#fund-loader-button').hide();
                                $('#fund-submit-btn').show();
                            }
                            });
                        });

                        // API Status (On/OFF)
                        $(document).off('change', '#apiBtn').on('change', '#apiBtn', function() {
                            const isChecked = $(this).is(':checked');
                            updateApiAccess(customerId, isChecked);
                        });

                        // Generate API
                        $(document).off('click', '.generate-api-key').on('click', '.generate-api-key', function() {
                            generateApiAccessKey(customerId);
                        });

                        // Reset API IP
                        $(document).off('click', '.reset-api-ip').on('click', '.reset-api-ip', function() {
                            resetApiIp(customerId);
                        });

                        // Copy API Key
                        $(document).off('click', '.api-access-copy').on('click', '.api-access-copy', function() {
                            const apiKey = $('#api-access-key').val();
                            copyToClipboard(apiKey);
                        });

                        // Copy API Username
                        $(document).off('click', '.api-user-copy').on('click', '.api-user-copy', function() {
                            const username = $('#api-username').val();
                            copyToClipboard(username);
                        });

                        // Copy API URL
                        $(document).off('click', '.api-url-copy').on('click', '.api-url-copy', function() {
                            const apiUrl = $('#api-url').val();
                            copyToClipboard(apiUrl);
                        });

                        // Copy Cunction
                        function copyToClipboard(text) {
                            navigator.clipboard.writeText(text);
                            notifier.show('COPIED!', text, 'success', '/resource/ok-48.png', 10000);
                        }

                        // Customer statement
                        $(document).off('click', '.statement-tab').on('click', '.statement-tab', function() {
                            customerStatement(customerId);
                        });

                        // Customer  Service List
                        $(document).off('click', '.service-tab').on('click', '.service-tab', function() {
                            serviceList(customerId);
                        });

                        // Update OverDue
                        $('#overdueBtn').off('change').on('change', function() {
                            const isChecked = $(this).is(':checked');
                            updateOverdue(customerId, isChecked);
                        });

                        // Update Status (Block/Unblock)
                        $(document).off('change', '#blockBtn').on('change', '#blockBtn', function() {
                            const isChecked = $(this).is(':checked');
                            updateBlock(customerId, isChecked);
                        });

                        // Remove 2FA For customer
                        $('#2faBtn').off('change').on('change', function() {
                            var checkbox = $(this);
                            if (!checkbox.prop('checked')) {
                                var userConfirmed = confirm("Are you sure you to turn off 2FA?");
                                if (userConfirmed) {
                                    $.ajax({
                                        url: `/admin/remove-customer-2fa/${customerId}`,
                                        method: 'GET',
                                        beforeSend: function() {
                                            $('.top-loader').show();
                                        },
                                        complete: function() {
                                            $('.top-loader').hide();
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                                                checkbox.prop('disabled', true);
                                            } else {
                                                checkbox.prop('checked', true);
                                                notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            checkbox.prop('checked', true);
                                            notifier.show('ERROR', error, 'danger', '/resource/high_priority-48.png', 10000);
                                        }
                                    });
                                } else {
                                    checkbox.prop('checked', true);
                                }
                            }
                        });


                        // Delete Customer
                        $(document).off('click', '#delBtn').on('click', '#delBtn', function() {
                            deleteCustomer(customerId);
                        });

                    }
                    else{
                        notifier.show('ERROR', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Error loading details. Please try again', 'danger', '/resource/high_priority-48.png', 10000);
                },
            });
        }

        // MENU FUNCTION INITIALIZE
        function initMenu() {
            $('.section').hide();
            $('#general').show();
            $('#menu button').on('click', function() {
                const section = $(this).data('section');
                $('.section').hide();
                $('#menu button').removeClass('active');
                $(this).addClass('active');
                $('#' + section).show();
            });
        }
        // UPDATE CUSTOM PRICE
        $(document).on('click', '.save-button', function() {
            const $listItem = $(this).closest('.customer-custom-price-list');
            const itemId = $listItem.data('id');
            const profitAmount = $listItem.find('input[type="number"]').val();
            if (!profitAmount || isNaN(profitAmount) || parseFloat(profitAmount) < 0) {
                notifier.show('ERROR', 'Enter valid amount', 'danger', '/resource/high_priority-48.png', 10000);
                return;
            }
            const data = {
                profit_amount: profitAmount
            };
            $.ajax({
                url: `/admin/update/custom/price/${itemId}`,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        notifier.show('Success!', 'Updated success!', 'success', '/resource/ok-48.png', 10000);
                    } else {
                        notifier.show('ERROR', 'Failed to update', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Please try again', 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        });
        // DELETE CUSTOM PRICE
        $(document).on('click', '.delete-button', function() {
            const itemId = $(this).closest('.customer-custom-price-list').data('id');
            if (confirm(`Are you sure to delete?`)) {
                $.ajax({
                    url: `/admin/del/custom/price/${itemId}`,
                    method: 'DELETE',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            $(this).closest('.customer-custom-price-list').remove();
                            notifier.show('Success!', 'Delete success!', 'success', '/resource/ok-48.png', 10000);
                        } else {
                            notifier.show('ERROR', 'Failed to delete', 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    }.bind(this),
                    error: function(xhr, status, error) {
                        notifier.show('ERROR', 'Error deleting the item', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            }
        });

        // Update Overdue
        function updateOverdue(customerId, isOverdueEnabled) {
            $.ajax({
                url: `/admin/update/overdue/${customerId}`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ overdue: isOverdueEnabled }),
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        reloadDataTable();
                        notifier.show('Success!', `Overdue is ${isOverdueEnabled ? 'enabled' : 'disabled'}.`, 'success', '/resource/ok-48.png', 10000);
                    } else {
                        notifier.show('ERROR', 'Failed to update. Please try again.', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Error updating. Please try again.', 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        }
        // Update API Access
        function updateApiAccess(customerId, isChecked) {
            const status = isChecked ? 'on' : '';
            $.ajax({
                url: `/admin/update-customer-api/${customerId}`,
                method: 'POST',
                data: { api: status },
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        notifier.show('Success!', `API is ${isChecked ? 'enabled' : 'disabled'}.`, 'success', '/resource/ok-48.png', 10000);
                        reloadDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'or occurred while updating API access.', 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        }
        // Generate New API Access Key
        function generateApiAccessKey(customerId) {
            const confirmGenerate = confirm("Are you sure to generate a new API key?");
            if (confirmGenerate) {
                $.ajax({
                    url: `/admin/generate-api-key/${customerId}`,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            notifier.show('Success!', `API key generated: ${response.api_key}`, 'success', '/resource/ok-48.png', 10000);
                            $('#api-access-key').val(response.api_key);
                        } else {
                            notifier.show('ERROR', 'Failed to generate API key.', 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        notifier.show('ERROR', 'Error occurred while updating API access.', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            }
        }
        // Reset API IP
        function resetApiIp(customerId) {
            $.ajax({
                url: `/admin/reset-api-ip/${customerId}`,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        notifier.show('Success!', 'IP reset success', 'success', '/resource/ok-48.png', 10000);
                        $('#api-allow-ip').val();
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Error occurred while reset api ip.', 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        }
        // STATEMENT - FUNCTION
        function customerStatement(customerId) {
            if ($.fn.dataTable.isDataTable('#statement-data-table')) {
                var table2 = $('#statement-data-table').DataTable();
                table2.clear();
                table2.rows.add(newData);
                table2.draw();
            }
            var table2 = $('#statement-data-table').DataTable({
                processing: false,
                serverSide: true,
                lengthChange: false,
                info: false,
                footer: false,
                ajax: {
                    url: `/admin/fetch-statement/${customerId}`,
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
                        title: 'DATE',
                        className: 'text-left',
                        orderable: false,
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
                    { data: 'description', title: 'DESCRIPTION', className: 'text-left', orderable: false},
                    {
                        data: 'type', title: 'TYPE', className: 'text-left', orderable: false,
                        render: function(data) {
                            if (data === 'Credit') {
                                return '<span class="badge bg-light-success text-uppercase">Credit</span>';
                            } else {
                                return '<span class="badge bg-light-danger text-uppercase">Debit</span>';
                            }
                        }
                    },
                    {   data: 'amount', title: 'AMOUNT', className: 'text-left', orderable: false,
                        render: function(data) {
                            const balanceValue = parseFloat(data);
                            const displayValue = balanceValue.toFixed(2) + ' $';
                            return displayValue;
                        }
                    },
                    {
                        data: 'balance',
                        title: 'BALANCE',
                        className: 'text-left',
                        orderable: false,
                        render: function(data) {
                            const balanceValue = parseFloat(data);
                            const displayValue = balanceValue.toFixed(2) + ' $';
                            return displayValue;
                        }
                    },
                    {
                        data: 'order_id',
                        title: '<span style="float:right">O.ID</span>',
                        className: 'text-right',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? `<span style="float:right">${data}</span>` : '<span style="float:right">-</span>';
                        }
                    },
                ],
                pageLength: 17,
                language: {
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                drawCallback: function(settings) {
                    $('.dataTables_wrapper .dataTables_paginate').hide();
                },
            });
            $('.cus-state-page-prev').on('click', function() {
                table2.page('previous').draw('page');
            });
            $('.cus-state-page-next').on('click', function() {
                table2.page('next').draw('page');
            });


        }

        // SERVICE LIST - FUNCTION
        function serviceList(customerId) {
            if ($.fn.dataTable.isDataTable('#service-data-table')) {
                var table = $('#service-data-table').DataTable();
                table.clear();
                table.rows.add(newData);
                table.draw();
            }
            var table = $('#service-data-table').DataTable({
                processing: false,
                serverSide: true,
                lengthChange: false,
                info: false,
                footer: false,
                ajax: {
                    url: `/admin/fetch-service/${customerId}`,
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
                        data: 'service_status', title: 'STATUS', className: 'text-left', orderable: false,
                        render: function(data) {
                            if (data === 'Success') {
                                return '<span class="badge bg-light-success text-uppercase">Success</span>';
                            } else if(data === 'In Process'){
                                return '<span class="badge bg-light-warning text-uppercase">In Process</span>';
                            } else if(data === 'Rejected'){
                                return '<span class="badge bg-light-danger text-uppercase">Rejected</span>';
                            }
                            else {
                                return '<span class="badge bg-light-primary text-uppercase">Waiting Action</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        title: 'DATE',
                        className: 'text-left',
                        orderable: false,
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
                        data: 'id',
                        title: 'O.ID',
                        className: 'text-right',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? `${data}` : '-';
                        }
                    },
                    {
                        data: 'service_price',
                        title: 'AMOUNT',
                        className: 'text-left',
                        orderable: false,
                        render: function(data) {
                            const balanceValue = parseFloat(data);
                            const displayValue = balanceValue.toFixed(2) + ' $';
                            return displayValue;
                        }
                    },
                    { data: 'service_qnt', title: 'QNT', className: 'text-left', orderable: false},
                    { data: 'service_title', title: 'SERVICE', className: 'text-left', orderable: false},
                ],
                pageLength: 17,
                drawCallback: function(settings) {
                    $('.dataTables_wrapper .dataTables_paginate').hide();
                },
            });
            $('.cus-ser-page-prev').on('click', function() {
                table.page('previous').draw('page');
            });
            $('.cus-ser-page-next').on('click', function() {
                table.page('next').draw('page');
            });
        }
        // UPDATE CUSTOMER STATUS - FUNCTION
        function updateBlock(customerId, isChecked) {
            const checkedData = isChecked ? 'Block' : 'Verified';
            $.ajax({
                url: `/admin/update-block/${customerId}`,
                method: 'POST',
                data: { status: checkedData },
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        notifier.show('Success!', `${isChecked ? 'Account Blocked' : 'Account Unblocked'}`, 'success', '/resource/ok-48.png', 10000);
                        reloadDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    notifier.show('ERROR', 'Error occurred while updating customer.', 'danger', '/resource/high_priority-48.png', 10000);
                }
            });
        }
        // DELETE CUSTOMER - FUNCTION
        function deleteCustomer(customerId) {
            const confirmDelete = confirm("Are you sure to delete?");
            if (confirmDelete) {
                $.ajax({
                    url: `/admin/del-customer/${customerId}`,
                    method: 'GET',
                    beforeSend: function() {
                        $('#delBtn').hide();
                        $('#delBtnLoader').show();
                    },
                    complete: function() {
                        $('#delBtn').show();
                        $('#delBtnLoader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            notifier.show('Success!', 'Delete success', 'success', '/resource/ok-48.png', 10000);
                            $('#customer-details').offcanvas('hide');
                            reloadDataTable();
                        } else {
                            notifier.show('ERROR', 'Failed to delete customer.', 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        notifier.show('ERROR', 'Error occurred while deleting.', 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            }
        }
        // ADD NEW CUSTOMER
        $(document).ready(function() {
            $('#new-customer-form').submit(function(e) {
                e.preventDefault();
                $('#new-update-button').hide();
                $('#new-loader-button').show();
                // Prepare form data
                var formData = {
                    name: $('#new-name').val(),
                    email: $('#new-email').val(),
                    mobile: $('#new-mobile').val(),
                    password: $('#new-password').val(),
                    currency: $('#new-currency').val(),
                    role: $('#new-role').val(),
                };
                $.ajax({
                    url: '/admin/customer/add-new',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#new-update-button').hide();
                        $('#new-loader-button').show();
                    },
                    complete: function() {
                        $('#new-update-button').show();
                        $('#new-loader-button').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#addNewCustomer').modal('hide');
                            $('#new-customer-form')[0].reset();
                            notifier.show('Success!', response.message, 'success', '/resource/ok-48.png', 10000);
                            reloadDataTable();
                        }
                        else{
                            notifier.show('Error', response.message, 'danger', '/resource/high_priority-48.png', 10000);
                        }
                    },
                    error: function(xhr, status, error) {
                        notifier.show('Error', error, 'danger', '/resource/high_priority-48.png', 10000);
                    }
                });
            });
        });



    });
</script>
@endsection
