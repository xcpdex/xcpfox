@extends('layouts.app')

@section('title', 'Types of Counterparty Transactions')
@section('canonical', url(route('charts.pie.transactions')))
@section('description', 'Breakdown of the types of Counterparty transactions written to the Bitcoin blockchain.')

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
    <p class="mt-3">Transactions are a subset of all the possible message types in the Counterparty protocol. Since, they're published on-chain, they represent the explicit state changes made to the Counterparty ledger. Other message types that exist represent the state changes that occur implicitly, off-chain, inside of federated nodes. For example, a Counterparty send is recorded on-chain, but the resulting debit and credits are recorded off-chain. See: <a href="{{ url(route('charts.pie.messages')) }}">Message Categories</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection