@extends('layouts.app')

@section('title', 'Block Share (% of Transactions)')
@section('canonical', url(route('charts.blockShare')))
@section('description', 'What percent of Bitcoin transactions are Counterparty transactions per month.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Block Share',
        'small' => '% Transactions',
    ])
    <chart
        source="{{ url(route('api.charts.blockShare')) }}"
        title="Block Share (% of Transactions)"
        yaxis="% of Transactions"
        type="line"
        cumulative="false"
    >
    </chart>
    <p class="mt-3">What this chart looks at is what percentage of Bitcoin transactions in an average block contain Counterparty protocol messages. We call this "block share" and it is based on the number of transactions in a block, regardless of the size of those blocks. For example, if in a given month there are 2.5 million bitcoin transactions and 25,000 of those transactions contain Counterparty data, then we would report Counterparty as having a 1% block share for that month. See: <a href="{{ url(route('charts.pie.blocks')) }}">Block Presence</a>.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection