@extends('layouts.app')

@section('title', 'Protocol Specification')
@section('canonical', url(route('protocol')))
@section('description', str_limit(trim(preg_replace( "/\r|\n/", " ", strip_tags(@markdown($content)))), 300))

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <h1>Protocol Specification</h1>
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