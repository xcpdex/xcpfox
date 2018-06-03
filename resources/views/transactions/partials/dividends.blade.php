<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset:</div>
    <div class="col-md-9">{{ $tx_data->asset }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Dividend Asset:</div>
    <div class="col-md-9">{{ $tx_data->dividend_asset }}</div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity Per Unit:</div>
    <div class="col-md-9">{{ $tx_data->quantity_per_unit_normalized }} {{ $tx_data->dividend_asset }} (${{ $tx_data->quantity_per_unit_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee Paid:</div>
    <div class="col-md-9">{{ $tx_data->fee_paid_normalized }} XCP (${{ $tx_data->fee_paid_usd_normalized }})</div>
</div>
@else
<?php $asset = \App\Asset::whereAssetName($tx_data->dividend_asset)->first(); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity Per Unit:</div>
    <div class="col-md-9">{{ $asset && $asset->divisible ? fromSatoshi($tx_data->quantity_per_unit) : $tx_data->quantity_per_unit }} {{ $tx_data->dividend_asset }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee Paid:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->fee_paid) }} XCP</div>
</div>
@endif