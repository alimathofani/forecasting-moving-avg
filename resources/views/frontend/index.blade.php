@extends('layouts.frontend')

@section('styles')
@endsection

@section('content')

  <section id="intro" class="clearfix">
    <div class="container d-flex h-100">
      <div class="row justify-content-center align-self-center">
        <div class="col-md-6 intro-info order-md-first order-last">
          <h2>Sistem Informasi<br><span>Forecasting</span></h2>
          <div>
          <a href="{{ route('login') }}" class="btn-get-started scrollto">Get Started</a>
          </div>
        </div>
  
        <div class="col-md-6 intro-img order-md-last order-first">
          <img src="{{ asset('frontend/img/undraw_growth_analytics_8btt.svg') }}" alt="" class="img-fluid">
        </div>
      </div>

    </div>
  </section>

@endsection

