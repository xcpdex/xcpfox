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
            Protocol Message
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Index:</div>
                <div class="col-md-9">{{ $message->message_index }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Category:</div>
                <div class="col-md-9">{{ $message_type }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Message Command:</div>
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
            <pre>{{ $bindings }}</pre>
        </div>
    </div>
</div>
@endsection