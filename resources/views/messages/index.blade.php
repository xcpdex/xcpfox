@extends('layouts.app')

@section('title', 'Counterparty Messages')

@section('header')
    <link rel="canonical" href="{{ url(route('messages.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <messages page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></messages>
</div>
@endsection