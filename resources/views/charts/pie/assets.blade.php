@extends('layouts.app')

@section('title', 'Types of Counterparty Assets')
@section('canonical',  url(route('charts.pie.assets')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Assets',
        'small' => 'By Type'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.assets')) }}"
        title="Counterparty Assets"
    >
    </chart-pie>
    @include('charts.partials.mobile-cta')
</div>
@endsection