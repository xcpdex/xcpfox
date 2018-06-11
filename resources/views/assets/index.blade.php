@extends('layouts.app')

@section('title', 'Counterparty Assets')
@section('canonical', url(route('assets.index')))

@section('content')
<div class="container mt-1">
    <assets page="{{ $request->input('page', 1) }}" per_page="{{ $request->input('per_page', 10) }}"></assets>
</div>
@endsection