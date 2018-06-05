@extends('layouts.app')

@section('title', 'Counterparty FAQ')

@section('content')
<div class="container mt-1">
    <h1>
        Counterparty FAQ
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Source: <a href="https://github.com/CounterpartyXCP/Documentation">CounterpartyXCP/Documentation</a>
        </div>
        <div class="card-body">
            @markdown($content)
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection