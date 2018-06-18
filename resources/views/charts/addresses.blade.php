@extends('layouts.app')

@section('title', $group_by === 'date' ? 'New Addresses Per Day' : 'New Addresses Per ' . ucfirst($group_by))
@section('canonical', url(route('charts.addresses')))
@section('description', 'Bitcoin addresses shown based on their first time seen using Counterparty.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'New Addresses',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.addresses', ['group_by' => $group_by])) }}"
        title="Counterparty New Addresses"
        yaxis="Addresses"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.addresses'])
    @include('charts.partials.mobile-cta')
</div>
@endsection