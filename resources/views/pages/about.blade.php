@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-6 offset-3 col-md-2 offset-md-1 mt-4">
            <img src="{{ asset('/images/icon-v1-large.png') }}" height="auto" width="100%" />
        </div>
        <div class="col-md-6 mt-4">
             <h1>About us</h1>
             <p class="lead">We believe in the future of cryptoassets. We build tools that help early crypto pioneers and risk takers analyze blockchain data for usage trends and actionable insights.</p>
        </div>
    </div>
    <h2 class="mt-5">Our Team</h2>
    <div class="row">
        <div class="col-md-3 offset-md-3">
            <div class="card mt-4">
                <div class="card-body">
                    <img src="{{ asset('/images/dan-anderson.jpg') }}" class="card-img rounded-circle" />
                    <h5 class="mt-3 font-weight-bold">Dan Anderson</h5>
                    <p class="card-text text-muted mb-2"><em>Project Lead</em></p>
                    <p class="card-text">Counterparty developer and asset holder with a background in data analytics.</p>
                    <p class="card-text"><a href="https://twitter.com/droplister" target="_blank"><i class="fa fa-twitter"></i></a> <a href="https://www.linkedin.com/in/iamdananderson/" target="_blank" class="ml-1"><i class="fa fa-linkedin"></i></a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mt-4">
                <div class="card-body">
                    <img src="{{ asset('/images/dante-deangelis.jpg') }}" class="card-img rounded-circle" />
                    <h5 class="mt-3 font-weight-bold">Dante DeAngelis</h5>
                    <p class="card-text text-muted mb-2"><em>Advisor</em></p>
                    <p class="card-text">Counterparty contributor and asset holder with a background in IT publishing.</p>
                    <p class="card-text"><a href="https://twitter.com/FLBitcoiner" target="_blank"><i class="fa fa-twitter"></i></a> <a href="https://www.linkedin.com/in/dante/" target="_blank" class="ml-1"><i class="fa fa-linkedin"></i></a></p>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.cta')
@endsection
