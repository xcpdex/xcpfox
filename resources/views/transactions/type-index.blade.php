@extends('layouts.app')

@section('title', 'Counterparty ' . ucfirst($type))
@section('canonical', url(route('transactions.typeIndex', ['type' => $type])))

@section('content')
<div class="container mt-1">
    <transactions type="{{ $type }}" page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></transactions>
</div>
@endsection