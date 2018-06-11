@extends('layouts.app')

@section('title', 'Counterparty Transactions')
@section('canonical', url(route('transactions.index')))

@section('content')
<div class="container mt-1">
    <transactions page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></transactions>
</div>
@endsection