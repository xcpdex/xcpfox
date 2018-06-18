@extends('layouts.app')

@section('title', 'Asset Registration Fee')
@section('canonical', url(route('charts.registrationFee')))
@section('description', 'Average Counterparty asset registration fee paid by asset issuers to create an asset of any type. Available in USD and XCP.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Registration Fee',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.registrationFee', ['currency' => $currency, 'group_by' => $group_by])) }}"
        title="Average Registration Fee"
        yaxis="{{ $currency }}"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.currency', ['route' => 'charts.registrationFee'])
    @include('charts.partials.mobile-cta')
</div>
@endsection