@extends('layouts.app')

@section('title', 'Counterparty Message Categories')
@section('canonical',  url(route('charts.pie.messages')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Messages',
        'small' => 'By Category'
    ])
    <chart-pie
        source="{{ url(route('api.charts.pie.messages')) }}"
        title="Counterparty Messages"
    >
    </chart-pie>
    @include('charts.partials.mobile-cta')
</div>
@endsection