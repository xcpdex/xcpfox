@extends('layouts.app')

@section('title', 'Counterparty Addresses')

@section('header')
    <link rel="canonical" href="{{ url(route('addresses.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <addresses page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></addresses>
</div>
@endsection