@extends('layouts.app')

@section('title', 'Search Results')

@section('header')
    <link rel="canonical" href="{{ url(route('search.index')) }}">
@endsection

@section('content')
<div class="container mt-1">
    <search q="{{ $request->input('q', '...') }}" page="1" per_page="25"></search>
</div>
@endsection