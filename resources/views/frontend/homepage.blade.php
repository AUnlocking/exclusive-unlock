@extends('layouts.frontend')
@section('content')
<div class="container">
    <div id="carouselExampleIndicators" class="carousel slide mb-4" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            @forelse ($sliders as $index => $slider)
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$index}}" class="{{ $index == 0 ? 'active' : '' }}"> </li>
            @empty
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"> </li>
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"> </li>
            @endforelse

        </ol>
        <div class="carousel-inner rounded">
            @forelse ($sliders as $index => $slider)
            <a href="{{ $slider->url }}" class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img class="img-fluid d-block w-100 rounded" src="{{ $slider->img }}" alt="slide" height="{{ $slider->height }}" width="{{ $slider->width }}">
            </a>
            @empty
            <a href="#" class="carousel-item active">
                <img class="img-fluid d-block w-100 rounded" src="{{asset('resource/slider.webp')}}" alt="slide" height="400" width="1100">
            </a>
            <a href="#" class="carousel-item">
                <img class="img-fluid d-block w-100 rounded" src="{{asset('resource/slider.webp')}}" alt="slide" height="400" width="1100">
            </a>
            @endforelse

        </div>
    </div>





    <div class="page-top-info-loader placeholder-glow" >
        <div class="row justify-content-start mb-4 mb-sm-2">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex py-2">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0" style="width: 100px;">
                                <span class="placeholder col-12 py-4 rounded bg-light-dark"></span>
                            </div>
                            <div class="flex-grow-1 col-12">
                                <p style="margin-bottom:8px" class="col-12">
                                    <span class="placeholder col-12 py-2 rounded bg-light-dark"></span>
                                </p>
                                <div>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                    <span class="placeholder col-5 py-2 rounded bg-light-dark"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12 service-tab">
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

@endsection
@section('seo')
<title>{{$siteTitle . ' - ' . $siteMetaTitle}}</title>
<meta name="description" content="{{$siteMetaDes}}"/>
<meta name="keywords" content="{{$siteKeyword}}"/>
@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('fetch_homepage_data') }}",
            type: 'GET',
            beforeSend: function() {
                $('.top-loader').show();
                $('.page-top-info-loader').show();
                $('.service-tab').hide();
            },
            complete: function() {
                $('.top-loader').hide();
                $('.page-top-info-loader').hide();
                $('.service-tab').show();
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
