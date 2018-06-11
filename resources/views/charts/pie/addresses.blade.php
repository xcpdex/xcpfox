@extends('layouts.app')

@section('title', 'Types of Counterparty Addresses')
@section('canonical',  url(route('charts.pie.addresses')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Addresses',
        'small' => 'By Type'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.addresses')) }}"
        title="Counterparty Addresses"
    >
    </chart-pie>
    @include('charts.partials.mobile-cta')
</div>
@endsection