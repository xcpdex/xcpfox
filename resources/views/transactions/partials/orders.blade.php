<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Give Asset:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $tx_data->give_asset])) }}">{{ $tx_data->give_asset }}</a></div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Give Quantity:</div>
    <div class="col-md-9">{{ $tx_data->give_quantity_normalized }} (${{ $tx_data->give_quantity_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Give Remaining:</div>
    <div class="col-md-9">{{ $tx_data->give_remaining_normalized }} (${{ $tx_data->give_remaining_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Asset:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $tx_data->get_asset])) }}">{{ $tx_data->get_asset }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Quantity:</div>
    <div class="col-md-9">{{ $tx_data->get_quantity_normalized }} (${{ $tx_data->get_quantity_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Remaining:</div>
    <div class="col-md-9">{{ $tx_data->get_remaining_normalized }} (${{ $tx_data->get_remaining_usd_normalized }})</div>
</div>
@else
<?php $give_asset = \App\Asset::whereAssetName($tx_data->give_asset)->first(); ?>
<?php $get_asset = \App\Asset::whereAssetName($tx_data->get_asset)->first(); ?>

<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Give Quantity:</div>
    <div class="col-md-9">{{ $give_asset && $give_asset->divisible ? fromSatoshi($tx_data->give_quantity) : $tx_data->give_quantity }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Give Remaining:</div>
    <div class="col-md-9">{{ $give_asset && $give_asset->divisible ? fromSatoshi($tx_data->give_remaining) : $tx_data->give_remaining }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Asset:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $tx_data->get_asset])) }}">{{ $tx_data->get_asset }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Quantity:</div>
    <div class="col-md-9">{{ $get_asset && $get_asset->divisible ? fromSatoshi($tx_data->get_quantity) : $tx_data->get_quantity }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Get Remaining:</div>
    <div class="col-md-9">{{ $get_asset && $get_asset->divisible ? fromSatoshi($tx_data->give_remaining) : $tx_data->give_remaining }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Expiration:</div>
    <div class="col-md-9">{{ $tx_data->expiration }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Expire Index:</div>
    <div class="col-md-9">{{ $tx_data->expire_index }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9">{{ $tx_data->status }}</div>
</div>