@extends('layouts.app')

@section('title', 'Asset Sends Chart')
@section('canonical',  url(route('charts.sends')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Asset Sends',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.sends', ['group_by' => $group_by])) }}"
        title="Counterparty Asset Sends"
        yaxis="Sends"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.sends'])
    @include('charts.partials.mobile-cta')
</div>
@endsection