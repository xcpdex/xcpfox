@extends('layouts.app')

@section('title', 'Types of Counterparty Transactions')
@section('canonical',  url(route('charts.pie.transactions')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Transactions',
        'small' => 'By Type'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.transactions')) }}"
        title="Counterparty Transactions"
    >
    </chart-pie>
    @include('charts.partials.mobile-cta')
</div>
@endsection