@extends('layouts.app')

@section('title', 'Fee Rates (Last 24 Hours)')
@section('canonical', url(route('charts.feeRates')))
@section('description', 'A closer look at the fee rates paid by Counterparty users over the last 24 hours. Includes confirmed transactions only.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Fee Rates',
        'small' => 'Last 24 Hours',
    ])
    <chart
        source="{{ url(route('api.charts.feeRates')) }}"
        title="Fee Rates Paid (sats/byte)"
        yaxis="TX Count"
        type="column"
        cumulative="false"
    >
    </chart>
    <p class="mt-3">This chart shows Counterparty transactions that have been confirmed in the last 24 hours. For critical, time-sensitive transactions, we recommend paying the average fee rate of {{ number_format($current->average) }} sats/byte. However, if you can afford to wait, transactions are being confirmed for as low as {{ number_format($current->minimum) }} sats/byte. Use the chart above to guide you, as there may be a fee rate between {{ number_format($current->minimum) }} and {{ number_format($current->average) }} sats/byte that gives you both affordability and moderate confirmation time, for example {{ floor($subset->average) }} sats/byte. See: <a href="{{ url(route('charts.areaRange.feeRate')) }}">Average Fee Rate</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection