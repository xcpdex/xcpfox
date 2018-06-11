@extends('layouts.app')

@section('title', 'Average Transaction Size')
@section('canonical',  url(route('charts.areaRange.transactionSize')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Size',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart-area-range
        source="{{ url(route('api.charts.areaRange.transactionSize')) }}"
        title="Average Transaction Size"
        yaxis="Bytes"
        group_by="{{ $group_by }}"
        combined="false"
    >
    </chart-area-range>
    @include('charts.partials.group-by', ['route' => 'charts.areaRange.transactionSize'])
    @include('charts.partials.mobile-cta')
</div>
@endsection