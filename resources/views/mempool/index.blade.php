@extends('layouts.app')

@section('title', 'Unconfirmed Transactions')
@section('canonical', url(route('mempool.index')))
@section('description', 'Counterparty transactions that have been broadcast, but are not confirmed and, in some cases, may never confirm.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <mempool page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></mempool>
</div>
@endsection