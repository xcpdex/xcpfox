@extends('layouts.app')

@section('title', 'Average Transaction Size')
@section('canonical', url(route('charts.areaRange.transactionSize')))
@section('description', 'Chart of the average size, in bytes, of a Counterparty transaction. Includes the range of transaction sizes too.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Size',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart-area-range
        source="{{ url(route('api.charts.areaRange.transactionSize', ['group_by' => $group_by])) }}"
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