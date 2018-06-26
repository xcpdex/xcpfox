@extends('layouts.app')

@section('title', $address->address)
@section('canonical', url(route('addresses.show', ['address' => $address->address])))
@section('description', 'Counterparty address balance and history.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>Address <small class="lead text-uppercase">{{ $address->type }}</small></h1>
    <div class="card my-4">
        <div class="card-header font-weight-bold">
            Address Information
        </div>
        <div class="card-body">
            @include('addresses.partials.address')
        </div>
    </div>
    <balances
        source="{{ url(route('api.balances.show', ['address' => $address->address])) }}"
    >
    </balances>
    @include('layouts.cta')
</div>
@endsection