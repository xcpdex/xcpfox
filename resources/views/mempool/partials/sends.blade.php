<?php $asset = \App\Asset::find($tx_data->asset); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ number_format($asset->divisible ? fromSatoshi($tx_data->quantity) : $tx_data->quantity, 8) }} <a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></div>
</div>
@if(isset($tx_data->memo))
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Memo:</div>
    <div class="col-md-9">{{ ctype_xdigit($tx_data->memo) ? hex2bin($tx_data->memo) : $tx_data->memo }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
@if($tx_data->destination)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Destination:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->destination])) }}">{{ $tx_data->destination }}</a></div>
</div>
@endif