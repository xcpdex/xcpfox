@extends('layouts.app')

@section('title', 'Bitcoin Blocks')
@section('canonical', url(route('blocks.index')))
@section('description', 'Stream of the latest bitcoin blocks mined and whether they contain any Counterparty messages.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <blocks
        page="{{ $request->input('page', 1) }}"
        per_page="{{ $request->input('per_page', 10) }}"
    >
    </blocks>
</div>
@endsection