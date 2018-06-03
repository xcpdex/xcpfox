@extends('layouts.app')

@section('title', 'Counterparty Transactions')

@section('header')
    <link rel="canonical" href="{{ url(route('transactions.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <transactions page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></transactions>
</div>
@endsection