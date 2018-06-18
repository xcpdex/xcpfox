@extends('layouts.app')

@section('title', 'Bitcoin Burned')
@section('canonical', url(route('charts.btcBurned')))
@section('description', 'Around 2,125 BTC were burned in order to "mine" the native currency called XCP.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'BTC Burned',
        'small' => 'Per Day',
    ])
    <chart
        source="{{ url(route('api.charts.btcBurned')) }}"
        title="Bitcoin Burned (IBO)"
        yaxis="BTC"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    <p class="mt-3">2,125.63000728 BTC were burned during a one month initial burn period in 2014 to create 2,649,791.07838225 XCP. There was no premine and no persons received these funds. This is an example of "Proof-of-Burn". There is a clear sunk cost that we can all agree occurred which lets us come to consensus on the total supply.</p>
    @include('charts.partials.mobile-cta')
</div>
@endsection