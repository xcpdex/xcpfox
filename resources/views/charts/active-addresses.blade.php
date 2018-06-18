@extends('layouts.app')

@section('title', $group_by === 'date' ? 'Active Addresses Per Day' : 'Active Addresses Per ' . ucfirst($group_by))
@section('canonical', url(route('charts.activeAddresses')))
@section('description', 'Active bitcoin addresses based on whether they had any Counterparty balance changes during period.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Active Addresses',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.activeAddresses', ['group_by' => $group_by])) }}"
        title="Active Counterparty Addresses"
        yaxis="Addresses"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.activeAddresses'])
    @include('charts.partials.mobile-cta')
</div>
@endsection