@extends('layouts.app')

@section('title', $address->address)

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>Address <small class="lead text-uppercase">{{ $address->type }}</small></h1>
    <div class="card my-4">
        <div class="card-header font-weight-bold">
            Address Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                @if($address->type === 'multisig')
                <div class="col-md-3 font-weight-bold font-weight-bold">Multisig:</div>
                <div class="col-md-9">
                    @foreach(array_values(array_filter(explode('_', $address->address), 'remove_keys')) as $m_address)
                        <a href="{{ url(route('addresses.show', ['address' => $m_address])) }}">{{ $m_address }}</a> @if(! $loop->last) </br > @endif
                    @endforeach
                </div>
                @else
                <div class="col-md-3 font-weight-bold font-weight-bold">Address:</div>
                <div class="col-md-9"><a href="https://bitcoinchain.com/block_explorer/address/{{ $address->address }}" target="_blank">{{ $address->address }}</a></div>
                @endif
            </div>
            @if($btc_amount)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Balance:</div>
                <div class="col-md-9">{{ $btc_amount->quantity_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a></div>
            </div>
            @else
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Balance:</div>
                <div class="col-md-9">0.00000000 <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a></div>
            </div>
            @endif
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">First Seen:</div>
                <div class="col-md-9">{{ $address->confirmed_at->toDayDateTimeString() }}</div>
            </div>
            @if($address->balances)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Last Seen:</div>
                <div class="col-md-9">{{ $address->balances()->latest('confirmed_at')->first() ? $address->balances()->latest('confirmed_at')->first()->confirmed_at->toDayDateTimeString() : $address->confirmed_at->toDayDateTimeString() }}</div>
            </div>
            @endif
        </div>
    </div>
    <balances source="{{ url(route('api.balances.show', ['address' => $address->address])) }}"></balances>
    @include('layouts.cta')
</div>
@endsection