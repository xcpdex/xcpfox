@extends('layouts.app')

@section('title', 'Counterparty Addresses')
@section('canonical', url(route('addresses.index')))

@section('content')
<div class="container mt-1">
    <addresses page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></addresses>
</div>
@endsection