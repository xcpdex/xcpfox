@extends('layouts.app')

@section('header')
    <meta name="robots" content="noindex,follow">
@endsection
@section('title', 'Counterparty Message #' . $message->message_index)
@section('canonical', url(route('messages.show', ['message' => $message->message_index])))
@section('description', 'A closer look at a particular state change made to the Counterparty ledger by a protocol message.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <a href="{{ url(route('messages.index')) }}" class="d-none d-sm-inline btn btn-outline-primary mt-1 float-right">&laquo; Back</a>
    <h1>Message <small class="lead">#{{ $message->message_index }}</small></h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Message Information
        </div>
        <div class="card-body">
            @include('messages.partials.message')
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Bitcoin Information
        </div>
        <div class="card-body">
            @include('messages.partials.bitcoin')
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            DB Message Bindings
        </div>
        <div class="card-body">
            <pre class="mb-0">{{ $bindings }}</pre>
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection