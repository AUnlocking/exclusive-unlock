canvaBodyHtml = `
    <div class="offcanvas-header bg-light-primary">
        <h5 class="offcanvas-title" id="announcementLabel">${'Gateway ' + '(' + response.gateway.NAME + ')'}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row mb-3">
            <label for="status" class="col-sm-3 col-form-label">Gateway Status</label>
            <div class="col-sm-9">
                <select class="form-select" id="status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="binance_api_key" class="col-sm-3 col-form-label">Binance API Key</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="binance_api_key" placeholder="Binance API Key" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="binance_secret_key" class="col-sm-3 col-form-label">Binance Secret Key</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="binance_secret_key" placeholder="Binance Secret Key" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="binance_charge" class="col-sm-3 col-form-label">Gateway Charge (%)</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="binance_charge" placeholder="Gateway Charge" required />
            </div>
        </div>

        <div class="row mb-3">
            <label for="customer_profit" class="col-sm-3 col-form-label">
                Pay QR Code
                <div class="d-flex gap-2">
                    <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-qr-code"><i class="fas fa-pencil-alt"></i></button></div>
                    <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-qr-code"><i class="fas fa-trash-alt"></i></button></div>
                </div>
            </label>
            <div class="col-sm-9 qr-code-section mt-4">
            </div>
        </div>

        <div class="my-4">
            <p>1. Get Binance <a href="https://www.binance.com/en/my/settings/api-management" target="_blank">API and Secret</a>.</p>
            <p>2. The QR Code can be found in the Binance App: Pay > Receive.</p>
            <p>3. Upload only the QR Code section. </p>
            <p>3. The QR Code resolution must be 300×300 pixels. </p>
        </div>


    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-primary rounded-0 w-100" id="update-gateway" style="height: 42px">
            <i class="fas fa-check-circle"></i> Update
            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinnerSuccess" role="status"></span>
        </button>
    </div>
`;

$('#gateway-details').html(canvaBodyHtml);
$('#status').val(response.gateway.STATUS || '');
$('#binance_api_key').val(response.gateway.API_KEY || '');
$('#binance_secret_key').val(response.gateway.SECRET_KEY || '');
$('#binance_charge').val(response.gateway.CHARGE || '');

if (response.gateway.QR_CODE) {
    $('.qr-code-section').html(`<img src="${response.gateway.QR_CODE}" alt="thumbnail" height="300" width="300" style="height:300px; max-width:100%" class="rounded">`);
} else {
    $('.qr-code-section').html(`<img src="{{asset('resource/default-thumb.png')}}" alt="thumbnail" height="200" width="300" style="height:200px; max-width:100%" class="rounded">`);
}


$('#update-gateway').off('click').on('click', function() {
    const formData = {
        Status: $('#status').val(),
        apiKey: $('#binance_api_key').val(),
        secretKey: $('#binance_secret_key').val(),
        charge: $('#binance_charge').val(),
    };
    let missingFields = [];
    if (!formData.Status) {
        missingFields.push('Status value');
    }
    if (!formData.apiKey) {
        missingFields.push('App Key');
    }
    if (!formData.secretKey) {
        missingFields.push('App Secret');
    }
    if (!formData.charge) {
        missingFields.push('Gateway charge');
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
        url: '/admin/update/pay-gateway/' + gatewayID,
        method: 'POST',
        data: formData,
        beforeSend: function() {
            $('.top-loader').show();
            $('#update-gateway').prop('disabled', true);
            $('#loadingSpinnerSuccess').removeClass('d-none');
        },
        complete: function() {
            $('.top-loader').hide();
            $('#update-gateway').prop('disabled', false);
            $('#loadingSpinnerSuccess').addClass('d-none');
        },
        success: function(response) {
            new Notify({
                status: `${response.success ? 'success' : 'error'}`,
                text: `${response.message}`,
                effect: 'fade',
                speed: 300,
                showIcon: true,
                showCloseButton: false,
                autoclose: true,
                autotimeout: 5000,
                notificationsGap: null,
                notificationsPadding: null,
                type: 'filled',
                position: 'left bottom',
            });
            if(response.success){
                $('#gateway-details').offcanvas('hide');
                reloadDataTable();
            }
        },
    });
});


// ADD QR CODE
$('.add-qr-code').on('click', function(){
    var gatewayId = gatewayID;
    $('#addImg').modal('show');
    loadModalIMG(gatewayId);
})

// REMOVE QR CODE
$('.remove-qr-code').off('click').on('click', function() {
    var gatewayId = gatewayID;
    if (confirm("Are you sure to remove the Binance QR Code?")) {
        let $btn = $(this); // Store reference to the button
        $btn.prop('disabled', true); // Disable the button to prevent multiple clicks
        $.ajax({
            url: '/admin/gateway/remove-qr-code/' + gatewayId,
            method: 'GET',
            beforeSend: function() {
                $('.top-loader').show();
            },
            complete: function() {
                $('.top-loader').hide();
                $btn.prop('disabled', false); // Re-enable the button
            },
            success: function(response) {
                if (response.success) {
                    $('.qr-code-section').html(`<img src="{{asset('resource/default-thumb.png')}}" alt="thumbnail" height="200" width="300" style="height:200px; max-width:100%" class="rounded">`);
                    reloadDataTable();
                }
                new Notify({
                    status: `${response.success ? 'success' : 'error'}`,
                    text: `${response.message}`,
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 5000,
                    notificationsGap: null,
                    notificationsPadding: null,
                    type: 'filled',
                    position: 'left bottom',
                });
            },
            error: function(xhr, status, error) {
                alert('Error occurred while updating..');
            }
        });
    }
});



function loadModalIMG(gatewayId){
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
                    return data ? `<img src="/media/${data}" alt="Thumbnail" width="70" height="47" class="rounded" >` : 'No Image';
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
        // order: [[1, 'asc']],
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
        // Show offcanvas
        createdRow: function(row, data, dataIndex) {
            $('td', row).off('click').on('click', function() {
                showSelectBtn(gatewayId, data.media_name);
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
        // Refresh the DataTable
        table.ajax.reload();
    });
}

$(document).ready(function() {
    // When files are selected
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
                // Handle error
                console.log(xhr.responseText);
                $('#response').html('<p>An error occurred while uploading the images.</p>');
            }
        });
    });
});
// END - Add image

function showSelectBtn(gatewayId, mediaName) {
    $('.selectIMG').show();
    $('.selectIMG').off('click').on('click', function() {
        $.ajax({
            url: '/admin/gateway/add-qr-code/' + gatewayId + '/' + mediaName,
            method: 'GET',
            beforeSend: function() {
                $('.top-loader').show();
            },
            complete: function() {
                $('.top-loader').hide();
            },
            success: function(response) {
                if (response.success) {
                    new Notify({
                        status: 'success',
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
                    $('#addImg').modal('hide');
                    $('.qr-code-section').html(`<img src="${response.url}" alt="thumbnail" height="300" width="300" style="height:300px; max-width:100%" class="rounded">`);
                    reloadDataTable();
                }
            },
            error: function(xhr, status, error) {
                alert('Error occurred while updating..');
            }
        });
    });
}
