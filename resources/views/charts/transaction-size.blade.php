@extends('layouts.app')

@section('title', 'Total Transaction Data')
@section('canonical',  url(route('charts.transactionSize')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Transaction Data',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.transactionSize', ['group_by' => $group_by])) }}"
        title="Total Transaction Data"
        yaxis="Bytes"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.transactionSize'])
    @include('charts.partials.mobile-cta')
</div>
@endsection