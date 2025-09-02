@extends('layouts.frontend')
@section('content')
<div class="container">

    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('frontend_credit_service')}}" class="breadcrumb-item active">Credit</a></li>
          <li class="breadcrumb-item active" aria-current="page">Place an Order</li>
        </ol>
    </nav>


    <div class="card">
        <h1 class="card-header display-1 fs-3">{{$serviceData->title}}</h1>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6 col-12 pe-md-3">
                    <lottie-player
                        src="{{ asset('resource/shoping-cart3.json') }}"
                        background="transparent"
                        speed="0.2"
                        loop
                        autoplay
                        >
                    </lottie-player>
                </div>
                <div class="col-md-6 col-12" >
                    <div class="text-bg-light ps-4 pt-4 pe-4 pb-4 border rounded" style="height: min-content">
                        <div class="table-responsive" >
                            <table class="table mb-4">
                                <tbody  @if (count($serviceInputs) != 0)class="border-bottom" @endif>
                                    @if ($Price)
                                    <tr>
                                        <td class="border-top-0 ps-0 pt-0"><b>Price</b></td>
                                        <td class="border-top-0 pt-0 text-end pe-0"><b>{{$currencyIcon}}{{$Price}} / Per Qnt</b></td>
                                    </tr>
                                    @endif
                                    @if ($serviceData->duration)
                                    <tr>
                                        <td class="ps-0"><b>Duration</b></td>
                                        <td class="text-end pe-0"><b>{{$serviceData->duration}}</b></td>
                                    </tr>
                                    @endif
                                    @if ($serviceData->delivery_time)
                                    <tr>
                                        <td class="ps-0"><b>Delivery</b></td>
                                        <td class="text-end pe-0"><b>{{$serviceData->delivery_time}}</b></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="Quantity">Quantity (Range should be <strong>{{$serviceData->min_qnt}}</strong> - <strong>{{$serviceData->max_qnt}}</strong>)</label>
                            <div class="input-group">
                              <input type="number" class="form-control quantity-input" id="Quantity" placeholder="Quantity" value="{{$serviceData->min_qnt}}" min="{{$serviceData->min_qnt}}" max="{{$serviceData->max_qnt}}" />
                              <span class="input-group-text justify-content-center calculated-amount" style="min-width: 100px"></span>
                            </div>
                        </div>

                        @if (count($serviceInputs) != 0)
                        <div class="mb-4">
                            @foreach ($serviceInputs as $index => $serviceInput)
                                @if ($chimeraBtn && $loop->first)
                                    <div class="mb-3">
                                        <label class="form-label" for="fields.{{ $index }}">Enter {{$serviceInput->name}}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="{{$serviceInput->name}}" id="fields.{{ $index }}" placeholder="{{$serviceInput->name}}">
                                            </div>
                                            <div class="col-md-6">
                                                <button id="chimera-check-user-button" class="w-100 rounded" style="height: 48px">&nbsp;</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label class="form-label" for="fields.{{ $index }}">Enter {{$serviceInput->name}}</label>
                                        <input type="text" class="form-control" name="{{$serviceInput->name}}" id="fields.{{ $index }}" placeholder="{{$serviceInput->name}}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @endif


                        @if (count($serviceTags) != 0)
                            <div class="mb-4 pb-3 pt-2 border-top border-bottom table-responsive">
                                @foreach ($serviceTags as $tag)
                                    @if ($tag == 'Process by')
                                        @if ($serviceData->api_id == 'Manual')
                                            <span class="badge bg-light-secondary pt-2 mt-2 border">Process by Admin</span>
                                        @else
                                            <span class="badge bg-light-secondary pt-2 mt-2 border">Process by API</span>
                                        @endif
                                    @else
                                        <span class="badge bg-light-secondary pt-2 mt-2 border">{{$tag}}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" id="form-check-input" type="checkbox" value="" {{$toc}} required />
                                <label class="form-check-label" for="form-check-input">I agree to <a href="#">terms and conditions</a></label>
                                <div class="invalid-feedback">You must agree before submitting.</div>
                            </div>
                        </div>
                        <div class="show-error-message"></div>


                        <div class="mb-1">
                            <button id="placeOrderBtn" class="btn btn-primary rounded w-100 place-order"><i class="fas fa-cart-plus"></i> Place an Order</button>
                            <button class="btn btn-primary rounded place-order-loader w-100" type="button" disabled style="display: none" >
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Loading...
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 pe-md-3">
                    <h2 class="display-1 fs-3">How Do I Place an Order?</h2>
                    <ol class="mt-4">
                        <li class="pb-3">First, log in to our website using your email.</li>
                        @if (count($serviceInputs) != 0)
                        <li class="pb-3">Next, fill in the required service input fields, such as @foreach ($serviceInputs as $index => $serviceInput){{$loop->first ? '' : ', '}}<strong>{{$serviceInput->name}}</strong>@endforeach.</li>
                        @endif
                        <li class="pb-3">Then, accept our terms and conditions by checking the <strong>Agree to terms and conditions</strong> box.</li>
                        <li class="pb-3">Click the <strong>Place an Order</strong> button to proceed. If your account has sufficient balance, the order will be placed. Otherwise, the available payment methods and a short summary will be displayed.</li>
                        <li class="pb-3">Select a payment gateway to complete your order.</li>
                        <li class="pb-3">Once the payment is successfully completed, your order will be placed.</li>
                    </ol>
                    @if ($serviceData->tool_download || $serviceData->login_url || $serviceData->register_url)
                    <h2 class="display-1 fs-3 mt-4">Resource</h2>
                    <div class="table-responsive" >
                        <table class="table">
                            <tbody>
                                @if ($serviceData->tool_download)
                                <tr>
                                    <td class="ps-0">Download Tool</td>
                                    <td class="text-end pe-0"><a class="badge bg-light-success" style="font-size: 13px; width:100px" href="{{$serviceData->tool_download}}" target="_blank"><i class="fas fa-cloud-download-alt"></i> Download</a></td>
                                </tr>
                                @endif
                                @if ($serviceData->login_url)
                                <tr>
                                    <td class="ps-0">Tool's Login Link</td>
                                    <td class="text-end pe-0"><a class="badge bg-light-success" style="font-size: 13px; width:100px" href="{{$serviceData->login_url}}" target="_blank"><i class="fas fa-external-link-alt"></i> Login</a></td>
                                </tr>
                                @endif
                                @if ($serviceData->register_url)
                                <tr>
                                    <td class="ps-0 pb-0">Tool's Register Link</td>
                                    <td class="text-end pe-0 pb-0"><a class="badge bg-light-success" style="font-size: 13px; width:100px" href="{{$serviceData->register_url}}" target="_blank"><i class="fas fa-external-link-alt"></i> Register</a></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    @if ($serviceData->screenshot)
                    <img src="{{$serviceData->screenshot}}" alt="" style="max-width: 100%" class="rounded border mb-4">
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($serviceData->article)
    <div class="card">
        <div class="card-body">
            {!!$serviceData->article!!}
        </div>
    </div>
    @endif
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 pt-2">
                <ul class="nav nav-tabs analytics-tab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hot-tab" data-bs-toggle="tab" data-bs-target="#hot-tab-pane" type="button" role="tab" aria-controls="hot-tab-pane" aria-selected="true" >
                            Recommended
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="trending-tab" data-bs-toggle="tab" data-bs-target="#trending-tab-pane" type="button" role="tab" aria-controls="trending-tab-pane" aria-selected="true">
                            Best Selling
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent-tab-pane" type="button" role="tab" aria-controls="recent-tab-pane" aria-selected="false">
                            Recent Added
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body px-4 py-0">
                <div class="row">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="hot-tab-pane" role="tabpanel" aria-labelledby="hot-tab" tabindex="0">
                            <ul class="list-group list-group-flush" id="hot-services"></ul>
                        </div>
                        <div class="tab-pane fade" id="trending-tab-pane" role="tabpanel" aria-labelledby="trending-tab" tabindex="0">
                            <ul class="list-group list-group-flush" id="trending-services"></ul>
                        </div>
                        <div class="tab-pane fade" id="recent-tab-pane" role="tabpanel" aria-labelledby="recent-tab" tabindex="0">
                            <ul class="list-group list-group-flush" id="recent-services"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Payment Gateway Modal --}}
@auth('customer')
<div class="modal fade modal-animate pe-0" id="paygateway" tabindex="-1" aria-labelledby="paygateway" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog h-md-auto " style="max-width: 650px">
        <div class="modal-content">
            <form action="{{ route('make_payment') }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paygatewayLabel">Choose Payment Gateway</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row mb-4 justify-content-center justify-content-md-start">
                                @foreach ($activeGateway as $Gateway)
                                <div class="checkbox-wrapper-16 py-2" style="width: 130px">
                                    <label class="checkbox-wrapper">
                                    <input type="radio" name="payment_methode" value="{{$Gateway->NAME}}" class="checkbox-input" required
                                    @if($Gateway->CURRENCY_CODE == auth()->guard('customer')->user()->currency) checked @elseif($loop->first) checked @endif />
                                    <span class="checkbox-tile w-fit-content">
                                        <span class="checkbox-icon">
                                            <img src="{{$Gateway->LOGO}}" alt="" height="40" width="60" class="rounded">
                                        </span>
                                        <span class="checkbox-label mt-1">{{$Gateway->NAME}}</span>
                                    </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4 ms-md-4 custom-left-border">
                            <h5 class="border-bottom py-2">{{$serviceData->title}}</h5>
                            <div id="modalInputs">
                                <div class="table-responsive" >
                                    <table class="table">
                                        <tbody >

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h5 class="border-bottom pt-4 pb-2">Payment</h5>
                            <div class="border-bottom py-2">Payment Gateway <span class="float-end" id="gatewayName"></span></div>
                            <div class="border-bottom py-2">Service Price <span class="float-end" id="ServicePrice"></span></div>
                            <div><span id="gatewayName2"></span> Charge <span id="gatewayCharge"></span> <span class="float-end" id="gatewayChargePercentage"></span></div>
                            <hr>
                            <h5>Total Amount <span class="float-end" id="totalPrice"></span></h5>
                        </div>
                        <input type="hidden" name="orderID" id="orderID">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary payment-gateway-btn" id="" type="submit">Pay with <span id="payGatewayName"></span></button>
                    <button class="btn btn-primary payment-gateway-loader" type="button" disabled style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection
@section('seo')
<title>{{$serviceData->title . ' - ' . $siteTitle}}</title>
<meta name="description" content="{{$serviceData->meta_description}}"/>
<meta name="keywords" content="{{$keyWord}}"/>
@endsection
@section('footer_script')
    @if ($chimeraBtn)
        <script type="text/javascript">
            var chimeraConfig = {};
            chimeraConfig.hash = 'a5732bca0b7f3141bda2e826091fd674'; // required
            chimeraConfig.usernameElementId = 'fields.0';
            chimeraConfig.usernameElementName = 'username';
            // Disable button initially
            document.getElementById("placeOrderBtn").disabled = true;
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = "https://data.chimeratool.com/init-reseller-transaction.js?v=" + Date.now();
            document.head.appendChild(s);
            document.addEventListener("chimeraAuthSuccess", function (e) {
                document.getElementById("placeOrderBtn").disabled = false;
            });
        </script>
    @endif
    @auth('customer')
        <script>
            // Initialize Update Gateway name + Charge + Pay Amount in Payment Modal
            function updateGatewayName(usdPrice) {
                var selectedGateway = $('input[name="payment_methode"]:checked').siblings('.checkbox-tile').find('.checkbox-label').text();
                var charges = @json($activeGateway);
                var currencies = @json($currencyList);
                var gatewayData = charges.find(gateway => gateway.NAME === selectedGateway);
                var gatewayCharge = gatewayData ? gatewayData.CHARGE : 0;
                var gatewayCurrency = gatewayData ? gatewayData.CURRENCY_CODE : 'USD';
                var currencyData = currencies.find(currency => currency.code === gatewayCurrency);
                var currencyRate = currencyData ? currencyData.rate : 1;
                var currencyIcon = currencyData ? currencyData.icon : '$';
                // Calculate the price after currency conversion
                var Price = (currencyRate * usdPrice);
                // Calculate the gateway charge percentage
                var gatewayChargePercentage = (gatewayCharge * Price) / 100;
                // Calculate the total price including the gateway charge
                var mainPrice = Price + gatewayChargePercentage;
                // Format the values to two decimal places
                Price = Price.toFixed(2);
                gatewayChargePercentage = gatewayChargePercentage.toFixed(2);
                mainPrice = mainPrice.toFixed(2);
                // Update the DOM with the calculated values
                $('#gatewayName').text(selectedGateway);
                $('#gatewayName2').text(selectedGateway);
                $('#payGatewayName').text(selectedGateway);
                $('#ServicePrice').text(currencyIcon + Price);
                $('#gatewayCharge').text('(' + gatewayCharge + '%)');
                $('#gatewayChargePercentage').text(currencyIcon + gatewayChargePercentage);
                $('#totalPrice').text(currencyIcon + mainPrice);
            }

            // Create Order
            $(document).off('click').on('click', '.place-order', function (e) {
                e.preventDefault();
                const formData = {
                    _token: '{{ csrf_token() }}',
                    serviceID: '{{ $serviceData->id }}',
                    Quantity: $('#Quantity').val(),
                };
                $('input[id^="fields"]').each(function () {
                    const fieldId = $(this).attr('id');
                    const fieldName = $(this).attr('placeholder');
                    const fieldValue = $(this).val().trim();
                    formData[fieldName] = fieldValue;
                });
                let missingFields = Object.entries(formData)
                    .filter(([key, value]) => !value && key !== '_token')
                    .map(([key]) => key);

                const termsAccepted = $('.form-check-input').is(':checked');
                if (!termsAccepted) {
                    missingFields.push('Terms and Conditions');
                }
                if (missingFields.length > 0) {
                    let message = missingFields
                        .map(field => `<strong>${field}</strong> is required`)
                        .join('<br>');
                    const errorMessage = `<div class="alert alert-danger" role="alert">${message}</div>`;
                    $('.show-error-message').html(errorMessage);
                    return false;
                }
                const jsonData = JSON.stringify(formData);
                $.ajax({
                    url: '{{route('create_order')}}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: jsonData,
                    beforeSend: function() {
                        $('.top-loader').show();
                        $('.place-order').hide();
                        $('.place-order-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                        $('.place-order').show();
                        $('.place-order-loader').hide();
                    },
                    success: function (response) {
                        if(response.inputserror){ // Show Input Errors
                            const errorMessage = `<div class="alert alert-danger" role="alert">${response.message}</div>`;
                            $('.show-error-message').html(errorMessage);
                        }
                        if(response.gateway){ // Show Payment Gateway Modal
                            $('#paygateway').modal('show');
                            let content = '';
                            response.orderInputs.forEach(input => {
                                content += `
                                    <tr>
                                        <td class="border-top-0 border-bottom ps-0 pt-2">${input.field_name}</td>
                                        <td class="border-top-0 border-bottom pt-2 text-end pe-0">${input.field_value}</td>
                                    </tr>
                                `;
                            });
                            $('#modalInputs tbody').html(content);
                            $('#orderID').val(response.orderid);
                            const usdPrice = response.usdPrice;
                            updateGatewayName(usdPrice);
                            $('input[name="payment_methode"]').on('change', function() {
                                updateGatewayName(usdPrice);
                            });
                        }
                        if(response.success){
                            window.location.href = response.redirectUrl;
                        }
                        if(response.error){
                            new Notify({
                                status: 'error',
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
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
                // Loader for Payment Gateway
                $(document).on('click', '.payment-gateway-btn', function (e) {
                    $('.top-loader').show();
                    $('.payment-gateway-btn').hide();
                    $('.payment-gateway-loader').show();
                });


            });
        </script>
    @else
        <script>
            $(document).off('click').on('click', '.place-order', function (e) {$('#login').modal('show');});
        </script>
    @endauth

    <script>
        function calculateCreditPrice() {
            var qntPrice = parseFloat({{ $Price }});
            var icon = "{{ $currencyIcon }}";
            var qnt = parseInt($('.quantity-input').val());
            var minQnt = parseInt({{ $serviceData->min_qnt }});
            var maxQnt = parseInt({{ $serviceData->max_qnt }});
            if (isNaN(qnt)) {
                qnt = minQnt;
            }
            var calculatedPrice = qntPrice * qnt;
            calculatedPrice = calculatedPrice.toFixed(2);
            $('.calculated-amount').text(icon + calculatedPrice);
        }
        $(document).ready(function() {
            $('input[type="number"]').first().focus();
            calculateCreditPrice();
            $(document).on('input', '.quantity-input', function() {
                var qnt = $(this).val();
                if (qnt.length > 6) {
                    $(this).val(qnt.slice(0, 6));
                }
                calculateCreditPrice();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('fetch_homepage_data') }}",
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    // Hot Service
                    response.hotServices.forEach(function(hot) {
                        var servicePrice = response.currencyIcon + parseFloat(hot.price).toFixed(2);
                        var routes = {
                            serverServiceView: "{{ route('server_service_view', '') }}",
                            frontendServerService: "{{ route('frontend_server_service') }}",
                            serverCreditView: "{{ route('credit_service_view', '') }}",
                            frontendCreditService: "{{ route('frontend_credit_service') }}",
                            serverImeiView: "{{ route('imei_service_view', '') }}",
                            frontendImeiService: "{{ route('frontend_imei_service') }}"
                        };
                        var serviceRoute = '#';
                        var categoryRoute = '#';
                        if (hot.service_type === 'Server Service') {
                            serviceTypeDisplay = 'Server';
                            serviceRoute = routes.serverServiceView + '/' + hot.slug;
                            categoryRoute = routes.frontendServerService;
                        } else if (hot.service_type === 'Credit Service') {
                            serviceTypeDisplay = 'Credit';
                            serviceRoute = routes.serverCreditView + '/' + hot.slug;
                            categoryRoute = routes.frontendCreditService;
                        } else if (hot.service_type === 'IMEI Service') {
                            serviceTypeDisplay = 'IMEI';
                            serviceRoute = routes.serverImeiView + '/' + hot.slug;
                            categoryRoute = routes.frontendImeiService;
                        }
                        var hotData = `
                            <li class="list-group-item px-0 pb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${hot.thumbnail}" alt="" width="75" height="50" class="rounded">
                                    <div class="flex-grow-1 ms-3">
                                        <div class="row g-1">
                                            <div class="col-md-6 col-12">
                                                <a href="${serviceRoute}"><p class="text-muted mb-1">${hot.title}</p></a>
                                                <div>
                                                    <span class="badge bg-light-primary" style="font-size:12px">${servicePrice}</span>
                                                    <span class="badge bg-light-warning" style="font-size:12px">${hot.delivery_time}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end d-md-block d-none">
                                                <h6 class="mb-1 text-muted"><a href="${categoryRoute}" class="btn btn-light-primary">${serviceTypeDisplay}</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                        $('#hot-services').append(hotData);
                    });
                    // Trending Service
                    response.trendingServices.forEach(function(trending) {
                        var servicePrice = response.currencyIcon + parseFloat(trending.price).toFixed(2);
                        var routes = {
                            serverServiceView: "{{ route('server_service_view', '') }}",
                            frontendServerService: "{{ route('frontend_server_service') }}",
                            serverCreditView: "{{ route('credit_service_view', '') }}",
                            frontendCreditService: "{{ route('frontend_credit_service') }}",
                            serverImeiView: "{{ route('imei_service_view', '') }}",
                            frontendImeiService: "{{ route('frontend_imei_service') }}"
                        };
                        var serviceRoute = '#';
                        var categoryRoute = '#';
                        if (trending.service_type === 'Server Service') {
                            serviceTypeDisplay = 'Server';
                            serviceRoute = routes.serverServiceView + '/' + trending.slug;
                            categoryRoute = routes.frontendServerService;
                        } else if (trending.service_type === 'Credit Service') {
                            serviceTypeDisplay = 'Credit';
                            serviceRoute = routes.serverCreditView + '/' + trending.slug;
                            categoryRoute = routes.frontendCreditService;
                        } else if (trending.service_type === 'IMEI Service') {
                            serviceTypeDisplay = 'IMEI';
                            serviceRoute = routes.serverImeiView + '/' + trending.slug;
                            categoryRoute = routes.frontendImeiService;
                        }
                        var trendingData = `
                            <li class="list-group-item px-0 pb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${trending.thumbnail}" alt="" width="75" height="50" class="rounded">
                                    <div class="flex-grow-1 ms-3">
                                        <div class="row g-1">
                                            <div class="col-md-6 col-12">
                                                <a href="${serviceRoute}"><p class="text-muted mb-1">${trending.title}</p></a>
                                                <div>
                                                    <span class="badge bg-light-primary" style="font-size:12px">${servicePrice}</span>
                                                    <span class="badge bg-light-warning" style="font-size:12px">${trending.delivery_time}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end d-md-block d-none">
                                                <h6 class="mb-1 text-muted"><a href="${categoryRoute}" class="btn btn-light-primary">${serviceTypeDisplay}</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                        $('#trending-services').append(trendingData);
                    });
                    // Recent Service
                    response.recentServices.forEach(function(recent) {
                        var servicePrice = response.currencyIcon + parseFloat(recent.price).toFixed(2);
                        var routes = {
                            serverServiceView: "{{ route('server_service_view', '') }}",
                            frontendServerService: "{{ route('frontend_server_service') }}",
                            serverCreditView: "{{ route('credit_service_view', '') }}",
                            frontendCreditService: "{{ route('frontend_credit_service') }}",
                            serverImeiView: "{{ route('imei_service_view', '') }}",
                            frontendImeiService: "{{ route('frontend_imei_service') }}"
                        };
                        var serviceRoute = '#';
                        var categoryRoute = '#';
                        if (recent.service_type === 'Server Service') {
                            serviceTypeDisplay = 'Server';
                            serviceRoute = routes.serverServiceView + '/' + recent.slug;
                            categoryRoute = routes.frontendServerService;
                        } else if (recent.service_type === 'Credit Service') {
                            serviceTypeDisplay = 'Credit';
                            serviceRoute = routes.serverCreditView + '/' + recent.slug;
                            categoryRoute = routes.frontendCreditService;
                        } else if (recent.service_type === 'IMEI Service') {
                            serviceTypeDisplay = 'IMEI';
                            serviceRoute = routes.serverImeiView + '/' + recent.slug;
                            categoryRoute = routes.frontendImeiService;
                        }
                        var recentData = `
                            <li class="list-group-item px-0 pb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${recent.thumbnail}" alt="" width="75" height="50" class="rounded">
                                    <div class="flex-grow-1 ms-3">
                                        <div class="row g-1">
                                            <div class="col-md-6 col-12">
                                                <a href="${serviceRoute}"><p class="text-muted mb-1">${recent.title}</p></a>
                                                <div>
                                                    <span class="badge bg-light-primary" style="font-size:12px">${servicePrice}</span>
                                                    <span class="badge bg-light-warning" style="font-size:12px">${recent.delivery_time}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end d-md-block d-none">
                                                <h6 class="mb-1 text-muted"><a href="${categoryRoute}" class="btn btn-light-primary">${serviceTypeDisplay}</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                        $('#recent-services').append(recentData);
                    });
                },
            });
        });
    </script>
@endsection

