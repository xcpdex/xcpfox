@extends('layouts.app')

@section('title', 'Presence in Bitcoin Blocks')
@section('canonical',  url(route('charts.pie.blocks')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Block Presence',
        'small' => '% Counterparty'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.blocks')) }}"
        title="Bitcoin Blocks"
    >
    </chart-pie>
    @include('charts.partials.mobile-cta')
</div>
@endsection