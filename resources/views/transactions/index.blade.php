@extends('layouts.app')

@section('title', $type ? 'Counterparty ' . ucfirst($type) : 'Counterparty Transactions')
@section('canonical', url(route('transactions.index')))
@section('description', 'Stream of the latest confirmed Counterparty transactions.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <transactions
        type="{{ $type }}"
        page="{{ $request->input('page', 1) }}"
        per_page="{{ $request->input('per_page', 10) }}"
    >
    </transactions>
</div>
@endsection