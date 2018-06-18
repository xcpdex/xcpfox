@extends('layouts.app')

@section('title', $group_by === 'date' ? 'Counterparty Transactions Per Day' : 'Counterparty Transactions Per ' . ucfirst($group_by))
@section('canonical', url(route('charts.transactions')))
@section('description', 'Chart showing the number of confirmed bitcoin transactions using Counterparty.')

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