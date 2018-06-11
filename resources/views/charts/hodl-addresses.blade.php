@extends('layouts.app')

@section('title', 'Counterparty Hodl Addresses')
@section('canonical',  url(route('charts.hodlAddresses')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Hodl Addresses',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.hodlAddresses', ['group_by' => $group_by])) }}"
        title="Counterparty Hodl Addresses"
        yaxis="Addresses"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.hodlAddresses'])
    @include('charts.partials.mobile-cta')
</div>
@endsection