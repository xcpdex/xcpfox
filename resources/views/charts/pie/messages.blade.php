@extends('layouts.app')

@section('title', 'Counterparty Message Categories')
@section('canonical', url(route('charts.pie.messages')))
@section('description', 'Breakdown of the types of Counterparty messages executed by the federated nodes.')

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
    <p class="mt-3">There exists exactly one protocol message for every change made to the Counterparty ledger. You can think of each message as recording some action that took place inside of federated nodes. It's important to understand that not all messages map one-to-one with a bitcoin transaction. In fact, transactions are a subset of messages and there are more changes that occur off-chain than are recorded on-chain in the Counterparty network. See: <a href="{{ url(route('charts.pie.transactions')) }}">Transaction Types</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection