@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">API Log</h5>
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
                url: '{{ route('fetch_api_log') }}',
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
                { data: 'api_action', title: 'ACTION', className: 'text-left', orderable: true, searchable: true },
                { data: 'sync_status', title: 'SYNC', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'api_message',
                    title: 'MESSAGE',
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
                { data: 'order_id', title: 'O.ID', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'order_title',
                    title: 'O.TITLE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function (data) {
                        if (data && data.length > 50) {
                            return `<span data-toggle="tooltip" title="${data}">${data.substring(0, 50)}...</span>`;
                        } else {
                            return `<span data-toggle="tooltip" title="${data}">${data}</span>`;
                        }
                    },
                    createdCell: function (td) {
                        $(td).tooltip();
                    }
                },
                {
                    data: 'status_code',
                    title: 'O.STATUS',
                    className: 'text-end',
                    orderable: true,
                    searchable: true,
                    render: function (data) {
                    switch (parseInt(data)) {
                    case 0:
                        return 'Waiting Action';
                    case 1:
                        return 'In Process';
                    case 3:
                        return 'Rejected';
                    case 4:
                        return 'Success';
                        default:
                            return '-';
                        }
                    }
                },
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
            }
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
    })
</script>
@endsection
