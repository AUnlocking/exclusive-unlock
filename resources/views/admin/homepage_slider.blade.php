@extends('layouts.admin')
@section('content')
<div class="alert alert-primary" role="alert">
    Recommended homepage slider resolution is <strong>1100x400 px</strong> (width: 1100px and height: 400px).
</div>
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Home Page Slider</h5>
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-light-primary border-primary rounded py-2 add-slider"><i class="fas fa-plus"></i></button>
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
<div
    class="offcanvas offcanvas-end"
    data-bs-scroll="true"
    tabindex="-1"
    id="slider-details"
    aria-labelledby="offcanvasWithBothOptionsLabel"
    >
    <div class="offcanvas-header border-bottom bg-primary">
        <h5 class="offcanvas-title text-uppercase text-white" id="offcanvasWithBothOptionsLabel">Slider Information</h5>
        <button type="button" class="btn-close text-reset text-white" data-bs-dismiss="offcanvas" aria-label="Close" style="color: white;"></button>
    </div>
    <div class="offcanvas-body"></div>
    <div class="offcanvas-footer">
        <div class="d-flex">
            <button type="button" class="btn btn-primary rounded-0 w-100 sliderUpdateBtn" id="rejectButton">
                <i class="fas fa-pencil-alt"></i> Update
            </button>
            <button type="button" class="btn btn-danger rounded-0 w-100 sliderDelBtn" id="successButton">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </div>
    </div>
</div>
{{-- Thumbnail Modal --}}
<div class="modal fade modal-animate" id="newSlider" tabindex="-1" aria-labelledby="addNewSlider" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 950px;">
        <div class="modal-content">
            <div class="modal-header gap-2 overflow-auto">
                <div>
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <label for="uploadimg" class="media-upload-btn"><i class="fas fa-cloud-upload-alt"></i></label>
                        <label class="media-upload-loader"><span class="spinner-border spinner-border-sm" id="loadingSpinnerSuccess" role="status"></span></label>
                        <input type="file" class="form-control py-2" name="image" id="uploadimg" accept="image/*" style="width: 150px; display: none">
                    </form>
                </div>
                <input type="search" class="form-control py-2 media-search" placeholder="Search" style="width: 200px">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 500px; overflow:auto">
                <div class="table-responsive " style="border: 1px solid #efefef">
                    <table id="modal-img-list" class="display table px-5">
                        <thead >
                            <tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon btn-primary page-prev"><i class="fas fa-angle-left"></i></button>
                <button type="button" class="btn btn-icon btn-primary page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                <div class="show-preview"></div>
                <button type="button" class="btn btn-light-primary selectIMG" style="display: none"><i class="fas fa-check-circle"></i> Select</button>
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
                url: '{{ route('fetch_slider') }}',
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
                    data: 'img',
                    title: 'IMAGE',
                    className: 'text-left',
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? `<img src="${data}" alt="Thumbnail" width="150" height="100" class="rounded" >` : 'No Image';
                    }
                },
                {
                    data: 'width',
                    title: 'RESOLUTION',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        if (data && row.height) {
                            return data + 'x' + row.height + ' px';
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'status',
                    title: 'STATUS',
                    className: 'text-end',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Active') {
                            return '<span class="badge bg-light-success fs-6">Active</span>';
                        } else if (data === 'Inactive') {
                            return '<span class="badge bg-light-danger fs-6">Inactive</span>';
                        }
                        return '<span class="badge bg-light-danger fs-6">Inactive</span>';
                    }
                },
            ],
            pageLength: 50,
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function() {
                    loadApiDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.dataTables_wrapper .dataTables_paginate').hide();
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
        function loadApiDetails(sliderID) {
            $.ajax({
                url: '/admin/fetch/slider-data/' + sliderID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    var imgHtml = `
                    <img src="${response.sliderData.img}" alt="Slider Image" class="img-fluid" style="max-width:100%">
                    <div class="mt-4">
                        <button class="btn btn-primary rounded w-100 SliderChangeBtn">Change</button>
                    </div>
                    <div class="mt-4">Width: ${response.sliderData.width}px</div>
                    <div>Height: ${response.sliderData.height}px</div>
                    <div class="mt-4">
                        <select name="" id="sliderStatus" class="form-control">
                            <option value="Active" ${response.sliderData.status === 'Active' ? 'selected' : ''}>Active</option>
                            <option value="Inactive" ${response.sliderData.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <input type="text" class="form-control" id="sliderUrl" name="sliderUrl" value="${response.sliderData.url || ''}" placeholder="URL">
                    </div>
                    <input type="hidden" id="sliderImgId" name="sliderImgId" value="${response.sliderData.id}">
                    `;
                    $('.offcanvas-body').html(imgHtml);
                    $('#slider-details').offcanvas('show');
                },
                error: function(xhr, status, error) {
                    alert('Error loading details: ' + error);
                },
            });
        }
        $('.sliderDelBtn').on('click', function(){
            var sliderID = $('#sliderImgId').val();
            if (confirm("Are you sure to delete this slider?")) {
                $.ajax({
                    url: '/admin/del-slider/' + sliderID,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
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
                        if (response.success) {
                            $('#slider-details').offcanvas('hide');
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading details: ' + error);
                    },
                });
            }
        })
        $('.sliderUpdateBtn').on('click', function(){
            const formData = {
                sliderID: $('#sliderImgId').val(),
                sliderStatus: $('#sliderStatus').val(),
                sliderUrl: $('#sliderUrl').val(),
                _token: '{{ csrf_token() }}',
            };
            let missingFields = [];
            if (!formData.sliderID) {
                missingFields.push('Id');
            }
            if (!formData.sliderStatus) {
                missingFields.push('Slider status');
            }
            if (!formData.sliderUrl) {
                missingFields.push('Slider URL');
            }
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                new Notify({
                    status: 'error',
                    text: message,
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
                return false;
            }
            $.ajax({
                url: '{{route('update_slider')}}',
                method: 'POST',
                data: formData,
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
                    if(response.success){
                        $('#slider-details').offcanvas('hide');
                        reloadDataTable();
                    }
                }
            });
        })

        // Add IMG
        $(document).on('click', '.add-slider', function(){
            var Action = 'add-slider';
            $('#newSlider').modal('show');
            loadModalIMG(Action);
        });
        $(document).on('click', '.SliderChangeBtn', function(){
            var sliderID = $('#sliderImgId').val();
            var Action = 'update-slider-' + sliderID;
            $('#newSlider').modal('show');
            loadModalIMG(Action);
        });
        function loadModalIMG(Action){
            if ($.fn.dataTable.isDataTable('#modal-img-list')) {
                $('#modal-img-list').DataTable().clear().destroy();
            }
            var table = $('#modal-img-list').DataTable({
                processing: false,
                serverSide: false,
                lengthChange: false,
                info: false,
                ajax: {
                    url: '{{ route('fetch_modal_img') }}',
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
                        data: 'media_name',
                        title: 'IMAGE',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data ? `<img src="/media/${data}" alt="Thumbnail" width="70" height="47" class="rounded" style="max-width:70px">` : 'No Image';
                        }
                    },
                    {
                        data: 'media_name',
                        title: 'NAME',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'media_size',
                        title: 'SIZE',
                        className: 'text-left',
                        orderable: true,
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
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data && row.media_height) {
                                return data + 'x' + row.media_height + ' px';
                            } else {
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
                pagingType: "simple",
                initComplete: function () {
                    $('.dataTables_length select').addClass('form-control dt-select-padding');
                },
                createdRow: function(row, data, dataIndex) {
                    $('td', row).on('click', function() {
                        showSelectBtn(data.media_name, Action);
                        var imageUrl = data.media_name ? "/media/" + data.media_name : "";
                        if (imageUrl) {
                            $('.show-preview').html(`<img src="${imageUrl}" alt="Preview" style="max-width: 100%; max-height: 40px;" class="rounded">`).show();
                        } else {
                            $('.show-preview').hide();
                        }
                    });
                }
            });
            $('.page-prev').on('click', function() {
                table.page('previous').draw('page');
            });
            $('.page-next').on('click', function() {
                table.page('next').draw('page');
            });
            $('.media-search').on('input', function() {
                var searchValue = this.value;
                if (searchValue.length === 0) {
                    table.search('').draw();
                } else {
                    table.search(searchValue).draw();
                }
            });
            $(document).on('imageUploadSuccess', function() {
                table.ajax.reload();
            });
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
                            $(document).trigger('imageUploadSuccess');

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $('#response').html('<p>An error occurred while uploading the images.</p>');
                    }
                });
            });
        });
        // Selected Media
        function showSelectBtn(mediaName, Action) {
            $('.selectIMG').show();
            $('.selectIMG').off('click').on('click', function() {
                $.ajax({
                    url: '/admin/add-slider/' + mediaName + '/' + Action,
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
                        if (response.success) {
                            $('#slider-details').offcanvas('hide');
                            $('#newSlider').modal('hide');
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        };



    });
</script>
@endsection
