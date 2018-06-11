@extends('layouts.app')

@section('title', 'Average Fee Rate')
@section('canonical',  url(route('charts.areaRange.feeRate')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Fee Rate',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart-area-range
        source="{{ url(route('api.charts.areaRange.feeRate')) }}"
        title="Average Fee Rate"
        yaxis="Sats/Byte"
        group_by="{{ $group_by }}"
        combined="false"
    >
    </chart-area-range>
    @include('charts.partials.group-by', ['route' => 'charts.areaRange.feeRate'])
    @include('charts.partials.mobile-cta')
</div>
@endsection