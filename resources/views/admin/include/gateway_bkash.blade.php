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
            <label for="bkash_app_key" class="col-sm-3 col-form-label">Bkash App Key</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="bkash_app_key" placeholder="Bkash App Key" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="bkash_app_secret" class="col-sm-3 col-form-label">Bkash App Secret</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="bkash_app_secret" placeholder="Bkash App Secret" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="bkash_username" class="col-sm-3 col-form-label">Bkash Username</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="bkash_username" placeholder="Bkash Username" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="bkash_password" class="col-sm-3 col-form-label">Bkash Password</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="bkash_password" placeholder="Bkash Password" required />
            </div>
        </div>
        <div class="row mb-3">
            <label for="bkash_charge" class="col-sm-3 col-form-label">Gateway Charge (%)</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="bkash_charge" placeholder="Gateway Charge" required />
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="" class="col-sm-5 col-form-label">
                        <h5 class="card-title">Sandbox</h5>
                        <div>
                            Enable this feature while validating the Bkash sandbox. For live mode, disable it.
                        </div>
                    </label>
                    <div class="col-sm-7">
                        <div class="form-check form-switch custom-switch-v1 float-end">
                            <input class="form-check-input input-primary" type="checkbox" id="bkash_sandbox" style="padding:15px 30px">
                        </div>
                    </div>
                </div>
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
$('#bkash_app_key').val(response.gateway.API_KEY || '');
$('#bkash_app_secret').val(response.gateway.SECRET_KEY || '');
$('#bkash_username').val(response.gateway.USERNAME || '');
$('#bkash_password').val(response.gateway.PASSWORD || '');
$('#bkash_charge').val(response.gateway.CHARGE || '');
if (response.gateway.SANDBOX === 'true') {
    $('#bkash_sandbox').prop('checked', true);
} else {
    $('#bkash_sandbox').prop('checked', false);
}
$('#update-gateway').off('click').on('click', function() {
    const formData = {
        Status: $('#status').val(),
        apiKey: $('#bkash_app_key').val(),
        secretKey: $('#bkash_app_secret').val(),
        Username: $('#bkash_username').val(),
        Password: $('#bkash_password').val(),
        charge: $('#bkash_charge').val(),
        Sandbox: $('#bkash_sandbox').prop('checked'),
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
    if (!formData.Username) {
        missingFields.push('Bkash Username');
    }
    if (!formData.Password) {
        missingFields.push('Bkash Password');
    }
    if (!formData.charge) {
        missingFields.push('Bkash charge');
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
