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

