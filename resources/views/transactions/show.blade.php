@extends('layouts.app')

<?php $a_an = in_array($tx_type[0], ['I', 'O']) ? 'an' : 'a'; ?>
@section('title', 'Counterparty Transaction ' . $transaction->tx_hash)
@section('canonical', url(route('transactions.show', ['tx_hash' => $transaction->tx_hash])))
@section('description', 'Full details about Counterparty Transaction #' . $transaction->tx_index . ' ' . $a_an . ' ' . strtolower($tx_type) . ' that was confirmed on ' . $transaction->confirmed_at->toDayDateTimeString() . '.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <a href="{{ url(route('transactions.index')) }}" class="d-none d-sm-inline btn btn-outline-primary mt-1 float-right">&laquo; Back</a>
    <h1>
        Transaction
        <small class="lead">
            #{{ $transaction->tx_index }}
        </small>
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            {{ $tx_type }} Information
        </div>
        <div class="card-body">
            @include('transactions.partials.' . $transaction->type)
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Bitcoin Information
        </div>
        <div class="card-body">
            @include('transactions.partials.transaction')
        </div>
    </div>
    @if($raw_tx)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Raw Transaction Data
        </div>
        <div class="card-body">
            <pre class="mb-0">{{ $raw_tx }}</pre>
        </div>
    </div>
    @endif
    @include('layouts.cta')
</div>
@endsection