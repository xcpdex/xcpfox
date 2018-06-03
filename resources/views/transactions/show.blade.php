@extends('layouts.app')

@section('title', 'Counterparty Transaction ' . $transaction->tx_hash)

@section('content')
<div class="container mt-1">
    <h1>
        Transaction
        <small class="lead">
            #{{ $transaction->tx_index }}
        </small>
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Transaction Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tx Hash:</div>
                <div class="col-md-9"><a href="{{ url(route('transactions.show', ['tx_hash' => $transaction->tx_hash])) }}">{{ $transaction->tx_hash }}</a></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Block Index:</div>
                <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $transaction->block_index])) }}">{{ $transaction->block_index }}</a></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Status:</div>
                <div class="col-md-9"><i class="fa {{ $transaction->valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> {{ $transaction->valid ? 'Valid' : ucfirst($tx_data->status) }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Timestamp:</div>
                <div class="col-md-9">{{ $transaction->confirmed_at->toDayDateTimeString() }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Source:</div>
                <div class="col-md-9">{{ $transaction->source }}</div>
            </div>
            @if($transaction->processed_at)
            @if($transaction->destination)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Destination:</div>
                <div class="col-md-9">{{ $transaction->destination }}</div>
            </div>
            @endif
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">BTC Sent:</div>
                <div class="col-md-9">{{ fromSatoshi($transaction->quantity) }} BTC @if($transaction->quantity) (${{ fromSatoshi($transaction->quantity_usd) }}) @endif</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tx Fee:</div>
                <div class="col-md-9">{{ fromSatoshi($transaction->fee) }} BTC @if($transaction->fee) (${{ fromSatoshi($transaction->fee_usd) }}) @endif</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tx Size:</div>
                <div class="col-md-9">{{ $transaction->size }} bytes ({{ $transaction->vsize }} vbytes)</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tx Weight:</div>
                <div class="col-md-9">{{ $transaction->vsize * 4 }} weight units</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Fee Rate:</div>
                <div class="col-md-9">{{ round($transaction->fee / $transaction->vsize) }} sats/byte</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Inputs:</div>
                <div class="col-md-9">{{ $transaction->inputs }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Outputs:</div>
                <div class="col-md-9">{{ $transaction->outputs }}</div>
            </div>
            @endif
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Counterparty Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Index:</div>
                <div class="col-md-9">{{ $transaction->message_index }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Type:</div>
                <div class="col-md-9">{{ $tx_type }}</div>
            </div>
            @include('transactions.partials.' . $transaction->type)
        </div>
    </div>
    @if($raw_tx)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Raw Transaction Data
        </div>
        <div class="card-body">
            <pre>{{ $raw_tx }}</pre>
        </div>
    </div>
    @endif
</div>
@endsection