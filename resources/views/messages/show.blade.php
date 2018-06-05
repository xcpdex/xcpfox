@extends('layouts.app')

@section('title', 'Counterparty Message #' . $message->message_index)

@section('header')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="container mt-1">
    <h1>
        Message
        <small class="lead">
            #{{ $message->message_index }}
        </small>
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Message Information
        </div>
        <div class="card-body">
            @if($message->transaction)
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tx Hash:</div>
                <div class="col-md-9"><a href="{{ url(route('transactions.show', ['transaction' => $message->transaction->tx_hash])) }}">{{ $message->transaction->tx_hash }}</a></div>
            </div>
            @endif
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Block Index:</div>
                <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $message->block_index])) }}">{{ $message->block_index }}</a></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Index:</div>
                <div class="col-md-9">{{ $message->message_index }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Category:</div>
                <div class="col-md-9">{{ $message_type }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Command:</div>
                <div class="col-md-9 text-capitalize">{{ $message->command }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Timestamp:</div>
                <div class="col-md-9">{{ $message->confirmed_at }} EST</div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Message Bindings
        </div>
        <div class="card-body">
            <pre class="mb-0">{{ $bindings }}</pre>
        </div>
    </div>
</div>
@endsection