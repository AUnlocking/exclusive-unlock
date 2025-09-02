@extends('layouts.frontend')
@section('content')
<div class="container">

    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>'">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}" class="breadcrumb-item active">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">404 - Not Found!</li>
        </ol>
    </nav>

    <div class="lottie-container" style="text-align: center;">
        <lottie-player
          src="{{ asset('resource/404.json') }}"
          background="transparent"
          speed="1"
          loop
          autoplay
          style="height: 400px;">
        </lottie-player>
        <a href="{{route('home')}}" class="btn btn-primary">Back To Home</a>
    </div>



</div>
@endsection
