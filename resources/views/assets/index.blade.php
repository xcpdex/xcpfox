@extends('layouts.app')

@section('title', $type ? 'Counterparty ' . str_plural(ucfirst($type)) : 'Counterparty Assets')
@section('canonical', url(route('assets.index', ['type' => $type])))
@section('description', 'Counterparty is a protocol and API for creating assets on the Bitcoin blockchain. Explore the latest assets registered on our website.')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    <assets
        type="{{ $type }}"
        page="{{ $request->input('page', 1) }}"
        per_page="{{ $request->input('per_page', 10) }}"
    >
    </assets>
</div>
@endsection