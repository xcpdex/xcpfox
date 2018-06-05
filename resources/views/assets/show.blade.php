@extends('layouts.app')

@section('title', $asset->display_name . ' Counterparty Asset')

@section('content')
<div class="container mt-1">
    <h1>
        {{ $asset->display_name }}
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Asset Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Description:</div>
                <div class="col-md-9">{{ $asset->description }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Issuance:</div>
                <div class="col-md-9">{{ number_format($asset->issuance_normalized, 8) }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Holders:</div>
                <div class="col-md-9">{{ $asset->current_balances_count }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Sends:</div>
                <div class="col-md-9">{{ $asset->sends_count }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Issuer:</div>
                <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->issuer])) }}">{{ $asset->issuer }}</a></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Owner:</div>
                <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->owner])) }}">{{ $asset->owner }}</a></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Issued:</div>
                <div class="col-md-9">{{ $asset->confirmed_at->toDayDateTimeString() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection