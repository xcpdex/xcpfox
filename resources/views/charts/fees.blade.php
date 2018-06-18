@extends('layouts.app')

@section('title', 'Total Transaction Fees')
@section('canonical', url(route('charts.fees')))
@section('description', 'Chart of the total transaction fees paid by all Counterparty users across the network. Available in USD and BTC.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Total Fees',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.fees', ['currency' => $currency, 'group_by' => $group_by])) }}"
        title="Counterparty Transaction Fees"
        yaxis="{{ $currency }}"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.currency', ['route' => 'charts.fees'])
    @include('charts.partials.mobile-cta')
</div>
@endsection