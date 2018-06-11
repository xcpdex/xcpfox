@extends('layouts.app')

@section('title', 'Fee Rates Paid (Last 7 Days)')
@section('canonical',  url(route('charts.feeRates')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Fee Rates Paid',
        'small' => 'Last 7 Days',
    ])
    <chart
        source="{{ url(route('api.charts.feeRates')) }}"
        title="Fee Rates Paid (sats/byte)"
        yaxis="TX Count"
        type="column"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.mobile-cta')
</div>
@endsection