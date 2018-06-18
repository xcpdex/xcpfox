@extends('layouts.app')

@section('title', 'Average Transaction Fee')
@section('canonical', url(route('charts.averageFee')))
@section('description', 'Chart of the average transaction fee paid by a Counterparty user. Availablel in USD and BTC.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Tx Fee',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.averageFee', ['currency' => $currency, 'group_by' => $group_by])) }}"
        title="Average Transaction Fee"
        yaxis="{{ $currency }}"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.currency', ['route' => 'charts.averageFee'])
    @include('charts.partials.mobile-cta')
</div>
@endsection