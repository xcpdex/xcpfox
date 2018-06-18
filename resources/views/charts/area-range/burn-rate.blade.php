@extends('layouts.app')

@section('title', 'Average Burn Rate')
@section('canonical', url(route('charts.areaRange.burnRate')))
@section('description', 'Up to 1 BTC could be burned in exchange for 1000 to 1500 XCP during the burn.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Average Burn Rate',
        'small' => 'Per Day',
    ])
    <chart-area-range
        source="{{ url(route('api.charts.areaRange.burnRate', ['group_by' => $group_by])) }}"
        title="Initial Burn Offering"
        yaxis="1 BTC = XCP"
        group_by="date"
        combined="true"
    >
    </chart-area-range>
    <p class="mt-3">In order to work optimally, Counterparty needs a "Counterparty aware" native platform currency. XCP was "mined" through what's known as "Proof-of-Burn" or more recently what's been called an "Initial Burn Offering." The burn rate people received started at 1500 XCP per 1 BTC burned and went down linearly until the last day.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection