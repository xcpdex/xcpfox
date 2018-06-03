@extends('layouts.app')

@section('title', 'Bitcoin Blocks')

@section('header')
    <link rel="canonical" href="{{ url(route('blocks.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <blocks page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></blocks>
</div>
@endsection