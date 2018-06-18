@extends('layouts.app')

@section('title', 'Types of Counterparty Addresses')
@section('canonical', url(route('charts.pie.addresses')))
@section('description', 'Breakdown of the types of addresses that users use: P2PKH, P2SH, Multisig.')

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
    <p class="mt-3">Due to the types of Bitcoin transactions that Counterparty currently supports, the majority of addresses are P2PKH. Once Counterparty supports SegWit, we expect to see this chart start to change. However, many people will continue using P2PKH addresses even after SegWit support is enabled, due to switching costs. Unless a new "transfer everything at my address" protocol message is added to the codebase. See: <a href="{{ url(route('charts.addresses')) }}">New Addresses Per Day</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection