@extends('layouts.app')

@section('title', 'Average Order Expiration')
@section('canonical',  url(route('charts.areaRange.orderExpiration')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Order Expiration',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart-area-range
        source="{{ url(route('api.charts.areaRange.orderExpiration')) }}"
        title="Average Order Expiration"
        yaxis="Blocks"
        group_by="{{ $group_by }}"
        combined="true"
    >
    </chart-area-range>
    @include('charts.partials.group-by', ['route' => 'charts.areaRange.orderExpiration'])
    @include('charts.partials.mobile-cta')
</div>
@endsection