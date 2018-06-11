@extends('layouts.app')

@section('title', 'Counterparty Transactions Chart')
@section('canonical',  url(route('charts.transactions')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Transactions',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.transactions', ['group_by' => $group_by])) }}"
        title="Counterparty Transactions"
        yaxis="Transactions"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.transactions'])
    @include('charts.partials.mobile-cta')
</div>
@endsection