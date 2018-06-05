@extends('layouts.app')

@section('title', 'Counterparty API Docs')

@section('content')
<div class="container mt-1">
    <h1>
        API Docs
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Source: <a href="https://github.com/CounterpartyXCP/Documentation">CounterpartyXCP/Documentation</a>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">XCPFox.com does not offer an API, at this time. If you are a developer, or interested in Counterparty data, we recommend using <a href="https://github.com/CounterpartyXCP/counterparty-lib">counterparty-lib</a>. It's the reference implementation of Counterparty and offers an excellent API. See Also: <a href="{{ url(route('node')) }}">Running a Node &raquo;</a></div>
            @markdown($content)
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection