@extends('layouts.app')

@section('title', $asset->display_name . ' Counterparty Asset')

@section('content')
<div class="container mt-1">
    <h1 class="mb-4">{{ $asset->display_name }}</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
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
                        <div class="col-md-9">{{ number_format($asset->issuance_normalized, 8) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 font-weight-bold font-weight-bold">Holders:</div>
                        <div class="col-md-9">{{ $asset->current_balances_count }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 font-weight-bold font-weight-bold">Issuer:</div>
                        <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->issuer])) }}">{{ $asset->issuer }}</a></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 font-weight-bold font-weight-bold">Owner:</div>
                        <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->owner])) }}">{{ $asset->owner }}</a></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 font-weight-bold">Issued:</div>
                        <div class="col-md-9">{{ $asset->confirmed_at->toDayDateTimeString() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Top 10 Holders
                </div>
                <div class="card-body">
                    @foreach($top_holders as $top_holder)
                    <div class="row mb-2">
                        <div class="col-7 col-md-6 font-weight-bold">{{ $top_holder->address }}</div>
                        <div class="col-5 col-md-6 text-right">{{ number_format($top_holder->quantity_normalized, 8) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Holders also own...
                </div>
                <div class="card-body">
                    @foreach($related_assets as $related_asset)
                    <div class="row mb-2">
                        <div class="col-6 font-weight-bold">{{ substr($related_asset->asset, 0, 1) === 'A' ? str_limit($related_asset->asset, 12) : $related_asset->asset }}</div>
                        <div class="col-3 text-right">{{ number_format($related_asset->count / $asset->current_balances_count * 100) }}%</div>
                        <div class="col-3 text-right">{{ number_format($related_asset->count) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection