@extends('layouts.app')

@section('title', 'Counterparty Assets')

@section('header')
    <link rel="canonical" href="{{ url(route('assets.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <assets page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></assets>
</div>
@endsection