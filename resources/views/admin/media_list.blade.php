@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Media</h5>
                    <div class="d-flex gap-1">
                        <input type="search" class="form-control py-2" id="image-search" placeholder="Search" />
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <label for="uploadimg" class="media-upload-btn"><i class="fas fa-cloud-upload-alt"></i></label>
                            <label class="media-upload-loader"><span class="spinner-border spinner-border-sm" id="loadingSpinnerSuccess" role="status"></span></label>
                            <input type="file" class="form-control py-2" name="image" id="uploadimg" accept="image/*" style="width: 150px; display: none">
                        </form>
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
                url: '{{ route('fetch_modal_img') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                error: function(xhr, error, thrown) {
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
                {
                    data: 'media_name',
                    title: 'IMAGE',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? `<img src="/media/${data}" alt="Thumbnail" width="70" height="47" class="rounded" >` : 'No Image';
                    }
                },
                { data: 'media_name', title: 'NAME', className: 'text-left', orderable: false, searchable: true },
                {
                    data: 'media_size',
                    title: 'SIZE',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        if (data) {
                            if (data > 1024 * 1024) {
                                return (data / (1024 * 1024)).toFixed(2) + ' MB';
                            } else if (data > 1024) {
                                return (data / 1024).toFixed(2) + ' KB';
                            } else {
                                return data + ' Bytes';
                            }
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'media_width',
                    title: 'RESOLUTION',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        if (data && row.media_height) {
                            return data + 'x' + row.media_height + ' px';
                        } else {
                            return '-';
                        }
                    }
                },
                { data: 'media_author', title: 'AUTHOR', className: 'text-left', orderable: false, searchable: true },
                {
                    data: 'media_name',
                    title: 'COPY URL',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        const domain = window.location.origin;
                        const fullUrl = domain + '/media/' + data;
                        return `
                            <button type="button" class="btn bg-light-success rounded py-1 px-2 copy-btn" data-url="${fullUrl}">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        `;
                    }
                },
                {
                    data: 'id',
                    title: '<span style="float:right">DELETE IMG</span>',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return `
                            <button type="button"
                                class="float-end btn bg-light-danger rounded py-1 px-2 delete-btn"
                                data-id="${data}"
                                data-name="${row.media_name}">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        `;
                    }
                }
            ],
            pageLength: 50,
            createdRow: function(row, data, dataIndex) {
                $(row).find('.copy-btn').on('click', function(event) {
                    event.stopPropagation();
                    var imgUrl = $(this).data('url');
                    var tempInput = document.createElement("input");
                    document.body.appendChild(tempInput);
                    tempInput.value = imgUrl;
                    tempInput.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempInput);
                    new Notify({
                        status: 'success',
                        title: 'URL Copied!',
                        effect: 'fade',
                        speed: 300,
                        customIcon: '<i class="fas fa-copy"></i>',
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                });
                $(row).find('.delete-btn').on('click', function(event) {
                    event.stopPropagation();
                    var imgID = $(this).data('id');
                    var imgName = $(this).data('name');
                    deleteIMG(imgID, imgName);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.dataTables_wrapper .dataTables_paginate').hide();
                $('.card-header h5').text('Media - ' + totalEntries);
            }
        });
        $('#image-search').on('input', function() {
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
        // Delete IMAGE
        function deleteIMG(imgID, imgName) {
            if (confirm('Are you sure to delete this image?\n' + imgName)) {
                $.ajax({
                    url: '/admin/del-media/' + imgID,
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
                            customClass: '',
                            customIcon: '<i class="fas fa-trash-alt"></i>',
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
                        if (response.success) {
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: Could not delete the image.');
                    }
                });
            }
        }
        // Upload IMG
        $(document).ready(function() {
            $('#uploadimg').on('change', function(e) {
                e.preventDefault();
                let formData = new FormData();
                $.each($('#uploadimg')[0].files, function(i, file) {
                    formData.append('image', file);
                });
                $.ajax({
                    url: '{{ route("upload_modal_img") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.top-loader').show();
                        $('.media-upload-btn').hide();
                        $('.media-upload-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                        $('#uploadimg').val('');
                        $('.media-upload-btn').show();
                        $('.media-upload-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: `${response.success ? 'success' : 'error'}`,
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
                            // $(document).trigger('imageUploadSuccess');
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });


    });
</script>
@endsection
