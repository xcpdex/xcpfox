@extends('layouts.app')

@section('title', $address->address)

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>Address <small class="lead text-uppercase">{{ $address->type }}</small></h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Address Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Address:</div>
                <div class="col-md-9">{{ $address->address }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">First Seen:</div>
                <div class="col-md-9">{{ $address->confirmed_at->toDayDateTimeString() }}</div>
            </div>
            @if($address->balances)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Last Seen:</div>
                <div class="col-md-9">{{ $address->balances()->latest('confirmed_at')->first()->confirmed_at->toDayDateTimeString() }}</div>
            </div>
            @endif
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection