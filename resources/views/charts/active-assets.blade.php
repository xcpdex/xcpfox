@extends('layouts.app')

@section('title', $group_by === 'date' ? 'Active Assets Per Day' : 'Active Assets Per ' . ucfirst($group_by))
@section('canonical', url(route('charts.activeAssets')))
@section('description', 'Active Counterparty assets, based on whether any holders had a change in their balance.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Active Assets',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.activeAssets', ['group_by' => $group_by])) }}"
        title="Active Counterparty Assets"
        yaxis="Assets"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.activeAssets'])
    @include('charts.partials.mobile-cta')
</div>
@endsection