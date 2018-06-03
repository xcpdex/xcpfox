@extends('layouts.app')

@section('title', 'Bitcoin Block #' . $block->block_index)

@section('header')
    <link rel="canonical" href="{{ url(route('blocks.show', ['block_hash' => $block->block_hash])) }}">
@endsection

@section('content')
<div class="container mt-1">
    <ul class="pagination mt-1 float-right">
        @if($prev_block)
        <li class="page-item"><a href="{{ url(route('blocks.show', ['block_hash' => $prev_block->block_hash])) }}" rel="prev" class="page-link">&laquo;</a></li>
        @else
        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @endif
        @if($next_block)
        <li class="page-item"><a href="{{ url(route('blocks.show', ['block_hash' => $next_block->block_hash])) }}" rel="prev" class="page-link">&raquo;</a></li>
        @else
        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
    <h1>
        Block
        <small class="lead">
            #{{ $block->block_index }}
        </small>
    </h1>
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
    @if(count($messages))
    <div class="row">
        <div class="col-12 mt-4 text-center text-muted">
            Other Counterparty Messages:<br />
            @foreach($messages as $message)
                @if($message->count > 1)
                {{ ucfirst($message->command) }} {{ str_replace('_', ' ', str_plural(getTitleFromType($message->category), $message->count)) }} ({{ $message->count }}){{ $loop->last ? '' : ',' }}
                @else
                {{ ucfirst($message->command) }} {{ str_replace('_', ' ', str_plural(getTitleFromType($message->category), $message->count)) }}{{ $loop->last ? '' : ',' }}
                @endif
            @endforeach
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12 mt-4 text-center">
            @if($prev_block)
            <a href="{{ url(route('blocks.show', ['block_hash' => $prev_block->block_hash])) }}" class="btn btn-outline-success mr-2" title="Go to block with Counterparty data">&laquo; {{ $next_block ? 'Prev' : 'Previous Block' }}</a>
            @endif
            @if($next_block)
            <a href="{{ url(route('blocks.show', ['block_hash' => $next_block->block_hash])) }}" class="btn btn-outline-success" title="Go to block with Counterparty data">{{ $prev_block ? 'Next' : 'Next Block' }} &raquo;</a>
            @endif
        </div>
    </div>
</div>
@endsection