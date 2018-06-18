@extends('layouts.app')

@section('title', 'Bitcoin Block #' . $block->block_index)
@section('canonical', url(route('blocks.show', ['block_hash' => $block->block_hash])))
@section('description', 'Counterparty Transactions in Bitcoin Block #' . $block->block_index . '.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    @include('blocks.partials.next-prev')
    <h1>Block <small class="lead">#{{ $block->block_index }}</small></h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Block Information
        </div>
        <div class="card-body">
            @include('blocks.partials.block')
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Counterparty Data
        </div>
        <div class="card-body">
            @include('blocks.partials.counterparty')
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4 text-center text-muted">
            {{ count($transactions) ? count($transactions) : 'No' }} Counterparty {{ str_plural('Transaction', count($transactions)) }}
        </div>
    </div>
    @foreach($transactions as $transaction)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            @include('blocks.partials.transaction-header')
        </div>
        <div class="card-body">
            @include('blocks.partials.transaction')
        </div>
    </div>
    @endforeach
    @include('blocks.partials.messages')
    @include('blocks.partials.next-prev-footer')
</div>
@endsection