@extends('layouts.app')

@section('title', 'Counterparty Gas Fees')
@section('canonical', url(route('charts.gasFees')))
@section('description', 'Chart of the total amoung of XCP burned as contract execution gas while registering assets and paying dividends.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Gas Fees',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.gasFees', ['group_by' => $group_by, 'currency' => $currency])) }}"
        title="Counterparty Gas Fees"
        yaxis="{{ $currency }}"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.currency', ['route' => 'charts.gasFees'])
    @include('charts.partials.mobile-cta')
</div>
@endsection