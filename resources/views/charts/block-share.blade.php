@extends('layouts.app')

@section('title', 'Block Transaction Share')
@section('canonical',  url(route('charts.blockShare')))

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Block Share',
        'small' => '% Transactions',
    ])
    <chart
        source="{{ url(route('api.charts.blockShare')) }}"
        title="Block Share (% Transactions)"
        yaxis="% Transactions"
        type="line"
        cumulative="false"
    >
    </chart>
    @include('charts.partials.mobile-cta')
</div>
@endsection