@extends('layouts.app')

@section('title', $address->address)

@section('content')
<div class="container mt-1">
    <h1>
        {{ $address->address }}
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Address Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Issued Assets:</div>
                <div class="col-md-9">{{ $address->issued_assets_count }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Owned Assets:</div>
                <div class="col-md-9">{{ $address->owned_assets_count }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">First Seen:</div>
                <div class="col-md-9">{{ $address->confirmed_at->toDayDateTimeString() }}</div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Testing Ground
        </div>
        <div class="card-body text-capitalize">
            <h5>Debits</h5>
            @foreach($address->debits()->selectRaw('COUNT(*) as count, action')->groupBy('action')->orderBy('count')->get() as $debit)
                {{ $debit->action }} - {{ number_format($debit->count) }}<br />
            @endforeach
            <br />
            <h5>Credits</h5>
            @foreach($address->credits()->selectRaw('COUNT(*) as count, action')->groupBy('action')->orderBy('count')->get() as $credit)
                {{ $credit->action }} - {{ number_format($credit->count) }}<br />
            @endforeach
            <br />
            <h5>Balances</h5>
            @foreach($address->currentBalances as $balance)
                {{ $balance->asset }} - {{ number_format($balance->quantity_normalized, 8) }}<br />
            @endforeach
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection