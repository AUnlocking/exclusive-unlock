@extends('layouts.frontend')
@section('content')
<div class="container">

    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('customer_dashboard')}}" class="breadcrumb-item active">My Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add Balance</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form action="{{route('customer_create_invoice')}}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-6 pe-md-4">
                                <h2 class="display-1 fs-4 fw-medium">Add Balance/Funds</h2>
                                <hr class="text-muted">
                                <div class="mb-4 pb-1">
                                    <label for="addAmountField" class="form-label">Enter <strong>{{$currency->code}}</strong> Amount</label>
                                    <input type="text" name="Amount" class="form-control" id="addAmountField" value="{{$add_amount}}" placeholder="Enter Amount">
                                </div>
                                <div class="row mb-4 justify-content-center justify-content-md-start mx-auto">
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
                            <div class="col-md-6 ps-md-4 custom-left-border">
                                <h5 class="border-bottom py-2 pt-0">Balance Information</h5>
                                <div id="modalInputs">
                                    <div class="table-responsive" >
                                        <table class="table">
                                            <tbody >
                                                <tr>
                                                    <td class="border-top-0 border-bottom ps-0 pt-2">Current Balance</td>
                                                    <td class="border-top-0 border-bottom pt-2 text-end pe-0 currentBal"></td>
                                                </tr>
                                                <tr>
                                                    <td class="border-top-0 border-bottom ps-0 pt-2">Balance After Deposit</td>
                                                    <td class="border-top-0 border-bottom pt-2 text-end pe-0 afterDepBal"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <h5 class="border-bottom pt-2 pb-2">Payment</h5>
                                <div class="border-bottom py-2">Payment Gateway <span class="float-end" id="gatewayName"></span></div>
                                <div class="border-bottom py-2">Deposit Amount <span class="float-end" id="ServicePrice"></span></div>
                                <div><span id="gatewayName2"></span> Charge <span id="gatewayCharge"></span> <span class="float-end" id="gatewayChargePercentage"></span></div>
                                <hr>
                                <h5>Total Pay <span class="float-end" id="totalPrice"></span></h5>
                                <hr>
                                <button type="submit" class="btn btn-primary w-100 rounded createInvoice">Pay with <span id="payGatewayName"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="my-4 text-muted">
            <div class="mt-lg-0 mt-4">
                <h2 class="display-1 fs-4 fw-medium">Term & Condition</h2>
                <ol class="ps-3">
                    <li class="py-1">Deposits are non-refundable, so please exercise caution before making a deposit on our website.</li>
                    <li class="py-1">Withdrawal requests are not permitted.</li>
                    <li class="py-1">Payment gateways impose fees, so you must pay an additional amount to cover these charges.</li>
                    <li class="py-1">Once the payment is completed, the deposit amount will be credited without any gateway charges.</li>
                    <li class="py-1">Service or product prices may change at any time.</li>
                </ol>
            </div>
        </div>
    </div>

</div>
@endsection
@section('seo')
<title>{{'Add Funds - ' . $siteTitle}}</title>
<meta name="description" content="Add Funds"/>
<meta name="keywords" content="Add Funds"/>
@endsection
@section('footer_script')
<script>
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
    function afterDepBalance(amount) {
        var currentPrice = parseFloat('{{$Customer->balance}}');
        var inputAmount = parseFloat(amount);
        var updatedBalance = currentPrice + inputAmount;
        var currencyCode = '{{$currency->code}}';
        $('.currentBal').text(currentPrice.toFixed(2) + ' ' + currencyCode);
        $('.afterDepBal').text(updatedBalance.toFixed(2) + ' ' + currencyCode);
    }
    function calculateUsdPrice(amount) {
        var customerRate = parseFloat('{{$currency->rate}}');
        return amount / customerRate;
    }
    function afterDepBal(depAmount){
        $('.depAmount').text(afterDepBal);
    }
</script>
<script>
    $(document).ready(function() {
        var input = $('input[type="text"]').first();
        input.focus();
        var inputValue = input.val();
        input.val('').val(inputValue);
        var depAmount = parseFloat($('#addAmountField').val()) || 0;
        // Initial Calculation
        var usdPrice = calculateUsdPrice(depAmount);
        updateGatewayName(usdPrice);
        afterDepBalance(depAmount);
        // Validate Input Fields
        $('#addAmountField').on('input', function() {
            let value = $(this).val();
            value = value.replace(/[^0-9]/g, '');
            if (value.length > 8) {
                value = value.slice(0, 8);
            }
            $(this).val(value);
        });
        // Update USD Price on input change
        $('#addAmountField').on('input', function() {
            depAmount = parseFloat($(this).val()) || 0;
            usdPrice = calculateUsdPrice(depAmount);
            afterDepBalance(depAmount);
            updateGatewayName(usdPrice);
        });
        // Update USD Price on payment method change
        $('input[name="payment_methode"]').on('change', function() {
            updateGatewayName(usdPrice);
        });
    });
</script>
@endsection
