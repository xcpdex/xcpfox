@extends('layouts.app')

@section('title', 'Block Presence (% Counterparty)')
@section('canonical', url(route('charts.pie.blocks')))
@section('description', 'What percent of Bitcoin blocks have contained Counterparty transactions since launch.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Block Presence',
        'small' => '% Counterparty'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.blocks')) }}"
        title="Bitcoin Blocks"
    >
    </chart-pie>
    <p class="mt-3">What this chart compares is Bitcoin blocks with Counterparty transactions against those without Counterparty transactions since the network was launched in 2014. This chart does not take into account the number of transactions. It looks only at whether or not any Counterparty transactions appear in a block. See: <a href="{{ url(route('charts.blockShare')) }}">Block Share</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection