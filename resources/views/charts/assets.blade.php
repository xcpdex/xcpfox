@extends('layouts.app')

@section('title', 'New Counterparty Assets')
@section('canonical',  url(route('charts.assets')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'New Assets',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.assets', ['group_by' => $group_by])) }}"
        title="New Counterparty Assets"
        yaxis="Registrations"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.assets'])
    @include('charts.partials.mobile-cta')
</div>
@endsection