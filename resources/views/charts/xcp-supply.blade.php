@extends('layouts.app')

@section('title', 'Total XCP Supply')
@section('canonical', url(route('charts.xcpSupply')))
@section('description', 'Chart of the total supply of Counterparty (XCP) which goes down over time, as XCP gets burned in contract executions.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'XCP Supply',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart-supply
        source="{{ url(route('api.charts.gasFees', ['group_by' => $group_by])) }}"
        title="Total XCP Supply"
        yaxis="Circulation"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
    >
    </chart-supply>
    @include('charts.partials.options', ['route' => 'charts.xcpSupply'])
    @include('charts.partials.mobile-cta')
</div>
@endsection