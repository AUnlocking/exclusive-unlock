@extends('layouts.admin')
@section('content')

<div class="alert alert-primary" role="alert">
    <h5 class="alert-heading">SET CORN JOB</h5>
    <p>We recommend to set corn job in <a href="https://cron-job.org/en/" target="_blank">https://cron-job.org/en</a> for automation. Also, you can set corn job in any provider.</p>
</div>

<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between"><h5 class="mb-3 mb-sm-0">PLACE ORDER</h5></div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive"><table id="place-order-data-table" class="display table px-5"><thead><tr></tr></thead></table></div>
            </div>
            <div class="card-footer" style="padding: 12px 15px">
                <a href="https://cron-job.org/en" target="_blank" type="button" class="btn btn-light-primary rounded"><i class="ti ti-circle-check"></i> Setup</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between"><h5 class="mb-3 mb-sm-0">GET ORDER</h5></div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive"><table id="get-order-data-table" class="display table px-5"><thead><tr></tr></thead></table></div>
            </div>
            <div class="card-footer" style="padding: 12px 15px">
                <a href="https://cron-job.org/en" target="_blank" type="button" class="btn btn-light-primary rounded"><i class="ti ti-circle-check"></i> Setup</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between"><h5 class="mb-3 mb-sm-0">AUTO UPDATE PRICE</h5></div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive"><table id="update-price-data-table" class="display table px-5"><thead><tr></tr></thead></table></div>
            </div>
            <div class="card-footer" style="padding: 12px 15px">
                <a href="https://cron-job.org/en" target="_blank" type="button" class="btn btn-light-primary rounded"><i class="ti ti-circle-check"></i> Setup</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between"><h5 class="mb-3 mb-sm-0">SITE CONFIGURATION</h5></div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive"><table id="site-config-data-table" class="display table px-5"><thead><tr></tr></thead></table></div>
            </div>
            <div class="card-footer" style="padding: 12px 15px">
                <a href="https://cron-job.org/en" target="_blank" type="button" class="btn btn-light-primary rounded"><i class="ti ti-circle-check"></i> Setup</a>
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
        // Place Order - Data Table
        var table = $('#place-order-data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_corn_placeorder') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
            },
            columns: [
                { data: 'corn_name', title: 'NAME OF CORN JOB', className: 'text-left', orderable: false, searchable: false },
                { data: 'corn_time', title: 'Execution Time', className: 'text-left', orderable: false, searchable: false },
                { data: 'corn_url', title: 'Corn Job URL', className: 'text-left', orderable: false, searchable: false },
                {
                    data: '',
                    title: 'Copy Url',
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return '<span class="badge bg-light-success fs-6 float-end copy-btn" data-url="' + row.corn_url + '"><i class="fas fa-copy"></i> Copy</span>';
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('.copy-btn').on('click', function() {
                    var cornUrl = $(this).data('url');
                    var tempInput = document.createElement("input");
                    document.body.appendChild(tempInput);
                    tempInput.value = cornUrl;
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    alert('Corn Job URL copied to clipboard!\n' + cornUrl);
                });
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });

        // Get Order - Data Table
        var table = $('#get-order-data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_corn_getorder') }}',
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
                    data: 'corn_name',
                    title: 'NAME OF CORN JOB',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_time',
                    title: 'Execution Time',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_url',
                    title: 'Corn Job URL',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: '',
                    title: 'Copy url',
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return '<span class="badge bg-light-success fs-6 float-end copy-btn" data-url="' + row.corn_url + '"><i class="fas fa-copy"></i> Copy</span>';
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadApiDetails(data.id);
                });
                $(row).find('.copy-btn').on('click', function(event) {
                    event.stopPropagation();
                    var cornUrl = $(this).data('url');
                    var tempInput = document.createElement("input");
                    document.body.appendChild(tempInput);
                    tempInput.value = cornUrl;
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    alert('Corn Job URL copied to clipboard!\n' + cornUrl);
                });
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });

        // Auto Update Price - Data Table
        var table = $('#update-price-data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_corn_updateprice') }}',
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
                    data: 'corn_name',
                    title: 'NAME OF CORN JOB',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_time',
                    title: 'Execution Time',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_url',
                    title: 'Corn Job URL',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: '',
                    title: 'Copy Url',
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return '<span class="badge bg-light-success fs-6 float-end copy-btn" data-url="' + row.corn_url + '"><i class="fas fa-copy"></i> Copy</span>';
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadApiDetails(data.id);
                });
                $(row).find('.copy-btn').on('click', function(event) {
                    event.stopPropagation();
                    var cornUrl = $(this).data('url');
                    var tempInput = document.createElement("input");
                    document.body.appendChild(tempInput);
                    tempInput.value = cornUrl;
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    alert('Corn Job URL copied to clipboard!\n' + cornUrl);
                });
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });

        // Site Config - Data Table
        var table = $('#site-config-data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_corn_siteconfig') }}',
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
                    data: 'corn_name',
                    title: 'NAME OF CORN JOB',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_time',
                    title: 'Execution Time',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'corn_url',
                    title: 'Corn Job URL',
                    className: 'text-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: '',
                    title: 'Copy Url',
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return '<span class="badge bg-light-success fs-6 float-end copy-btn" data-url="' + row.corn_url + '"><i class="fas fa-copy"></i> Copy</span>';
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('.copy-btn').on('click', function(event) {
                    event.stopPropagation();
                    var cornUrl = $(this).data('url');
                    var tempInput = document.createElement("input");
                    document.body.appendChild(tempInput);
                    tempInput.value = cornUrl;
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    alert('Corn Job URL copied to clipboard!\n' + cornUrl);
                });
            },
            drawCallback: function(settings) {
                $('.dataTables_wrapper .dataTables_paginate').hide();
            }
        });


    })
</script>
@endsection
