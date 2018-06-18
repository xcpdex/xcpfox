@extends('layouts.app')

<?php $a_an = in_array($tx_type[0], ['I', 'O']) ? 'an' : 'a'; ?>
@section('title', 'Counterparty Transaction ' . $mempool->tx_hash)
@section('canonical', url(route('transactions.show', ['tx_hash' => $mempool->tx_hash])))
@section('description', 'Counterparty Transaction pending confirmation. This ' . strtolower($tx_type) . ' was first seen ' . \Carbon\Carbon::createFromTimestamp($mempool->timestamp)->diffForHumans() . '. Click for details.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>
        Transaction
        <small class="lead">
            Pending
        </small>
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            {{ $tx_type }} Information
        </div>
        <div class="card-body">
            @include('mempool.partials.' . $mempool->category)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Status:</div>
                <div class="col-md-9"><i class="fa fa-times-circle text-danger"></i> Unconfirmed</div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Bitcoin Information
        </div>
        <div class="card-body">
            @include('mempool.partials.transaction')
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection