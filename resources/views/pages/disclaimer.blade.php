@extends('layouts.app')

@section('title', 'Disclaimer')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>Disclaimer</h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Last Updated: 06/05/2018
        </div>
        <div class="card-body">
            <h3>No Investment Advice</h3>
            <p>The information provided on this website does not constitute investment advice, financial advice, trading advice, or any other sort of advice and you should not treat any of the website's content as such. XCP FOX does not recommend that any cryptocurrency should be bought, sold, or held by you. Do conduct your own due diligence and consult your financial advisor before making any investment decisions.</p>
            <h3>Accuracy of Information</h3>
            <p>XCP FOX will strive to ensure accuracy of information listed on this website although it will not hold any responsibility for any missing or wrong information. XCP FOX provides all information as is. You understand that you are using any and all information available here at your own risk.</p>
        </div>
    </div>
    @include('layouts.cta')
@endsection
