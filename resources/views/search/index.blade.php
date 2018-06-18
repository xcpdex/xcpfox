@extends('layouts.app')

@section('title', 'Search Results')
@section('canonical', url(route('search.index')))

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <search q="{{ $request->input('q', '...') }}" page="1" per_page="25"></search>
</div>
@endsection