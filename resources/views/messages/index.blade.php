@extends('layouts.app')

@section('title', 'Counterparty Messages')
@section('canonical', url(route('messages.index')))
@section('description', 'Stream of the latest Counterparty protocol messages that have been executed by federated nodes.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <messages
        page="{{ $request->input('page', 1) }}"
        per_page="{{ $request->input('per_page', 10) }}"
    >
    </messages>
</div>
@endsection