<?php $asset = \App\Asset::whereAssetName($tx_data->asset)->first(); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset Name:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></div>
</div>
<?php $dividend_asset = \App\Asset::whereAssetName($tx_data->dividend_asset)->first(); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Dividend:</div>
    <div class="col-md-9">{{ $dividend_asset && $dividend_asset->divisible ? fromSatoshi($tx_data->quantity_per_unit) : $tx_data->quantity_per_unit }} <a href="{{ url(route('assets.show', ['asset' => $dividend_asset->display_name])) }}">{{ $dividend_asset->display_name }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee Paid:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->fee_paid) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>