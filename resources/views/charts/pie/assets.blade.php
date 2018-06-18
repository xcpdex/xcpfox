@extends('layouts.app')

@section('title', 'Types of Counterparty Assets')
@section('canonical', url(route('charts.pie.assets')))
@section('description', 'Breakdown of the types of Counterparty assets that users register: asset, subasset, or numeric.')

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
    <p class="mt-3">There are three types of Counterparty assets: named (MYTOKEN), numeric (A10000000000000000000), and subasset (MYTOKEN.COUPON). And each has its own registration fee: named (0.5 XCP), numeric (FREE), subasset (0.25 XCP). See: <a href="{{ url(route('charts.registrationFee')) }}">Registration Fees</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection