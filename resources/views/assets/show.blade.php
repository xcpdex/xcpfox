@extends('layouts.app')

@section('title', $asset->display_name)

@section('content')
<div class="container mt-1">
    <h1>
        {{ $asset->display_name }}
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Asset Information
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Description:</div>
                <div class="col-md-9">{{ $asset->description }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Issuance:</div>
                <div class="col-md-9">{{ $asset->issuance_normalized }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Holders:</div>
                <div class="col-md-9">{{ $asset->balances_count }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold font-weight-bold">Sends:</div>
                <div class="col-md-9">{{ $asset->sends_count }}</div>
            </div>
        </div>
    </div>
</div>
@endsection