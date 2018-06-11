@extends('layouts.app')

@section('title', 'Counterparty Orders Chart')
@section('canonical',  url(route('charts.orders')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Dex Orders',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.orders', ['group_by' => $group_by])) }}"
        title="Counterparty Dex Orders"
        yaxis="Orders"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.orders'])
    @include('charts.partials.mobile-cta')
</div>
@endsection