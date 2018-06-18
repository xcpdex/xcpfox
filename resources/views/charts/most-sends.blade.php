@extends('layouts.app')

@section('title', 'Most Sent Assets')
@section('canonical', url(route('charts.mostSends')))
@section('description', 'A look at the top 20 most sent Counterparty assets of all time.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Most Sends',
        'small' => 'All Time',
    ])
    <chart
        source="{{ url(route('api.charts.mostSends')) }}"
        title="Most Sent Assets"
        yaxis="Total Sends"
        type="column"
        cumulative="false"
    >
    </chart>
    <p class="mt-3">It may be surprising to learn that XCP is not the most sent asset on the Counterparty network, but it demonstrates one of the more interesting aspects of how the network functions. XCP is not simply jammed into every aspect of the protocol. It's conceivable that a project could make little to no use of XCP. See: <a href="{{ url(route('faq')) }}">What is XCP?</a></p>
    @include('charts.partials.mobile-cta')
</div>
@endsection