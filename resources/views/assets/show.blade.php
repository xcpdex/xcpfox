@extends('layouts.app')

@section('title', $asset->display_name === 'BTC' ? 'BTC Holder Information' : $asset->display_name . ' Asset Information')
@section('canonical', url(route('assets.show', ['asset' => $asset->display_name])))
@section('description', '')

@section('content')
<div class="container mt-1">
    @include('layouts.ads')
    @include('assets.partials.page-title')
    @include('assets.partials.market-history')
    <div class="row">
        <div class="{{ $asset->current_balances_count > 0 ? 'col-md-8' : 'col-md-12' }}">
            <div class="card mt-4">
                <div class="card-header font-weight-bold">
                    Asset Information
                </div>
                <div class="card-body">
                    @include('assets.partials.asset')
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header font-weight-bold">
                    Issuance Settings
                </div>
                <div class="card-body">
                    @include('assets.partials.issuance-settings')
                </div>
            </div>
        </div>
        @if($asset->current_balances_count > 0)
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-header font-weight-bold">
                    Holders also own...
                </div>
                <div class="card-body">
                    <list-assets
                         source="{{ url(route('api.charts.assets.relatedAssets', ['asset_name' => $asset->asset_name])) }}"
                     >
                     </list-assets>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if($asset->asset_name !== 'BTC' && $asset->current_balances_count > 0)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Holders <small class="ml-1">{{ number_format($asset->current_balances_count) }} <span class="text-muted ml-1">(Current)</span></small>
        </div>
        <div class="card-body">
            @include('assets.partials.holder-addresses')
        </div>
    </div>
    @endif
    @if($asset->asset_name !== 'BTC' && $asset->sends_count > 0)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Sends <small class="ml-1">{{ number_format($asset->sends_count) }} Total</small>
        </div>
        <div class="card-body">
            @include('assets.partials.unique-sends')
        </div>
    </div>
    @endif
    @if($trades_count > 0)
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Trades <small class="ml-1">{{ number_format($trades_count) }} Total</small>
        </div>
        <div class="card-body">
            @include('assets.partials.unique-trades')
        </div>
    </div>
    @endif
    @include('layouts.cta')
</div>
@endsection