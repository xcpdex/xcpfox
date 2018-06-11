@extends('layouts.app')

@section('title', 'Active Counterparty Addresses')
@section('canonical',  url(route('charts.activeAddresses')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Active Addresses',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.activeAddresses', ['group_by' => $group_by])) }}"
        title="Counterparty Active Addresses"
        yaxis="Addresses"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.activeAddresses'])
    @include('charts.partials.mobile-cta')
</div>
@endsection