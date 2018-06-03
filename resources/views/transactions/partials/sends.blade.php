<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $tx_data->asset])) }}">{{ $tx_data->asset }}</a></div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">@if($tx_data->burn) <i class="fa fa-fire text-warning"></i> @endif {{ $tx_data->quantity_normalized }} (${{ $tx_data->quantity_usd_normalized }})</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ $tx_data->quantity }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Destination:</div>
    <div class="col-md-9">{{ $tx_data->destination ? $tx_data->destination : 'N/A' }}</div>
</div>
@if(isset($tx_data->memo) && $tx_data->memo)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Memo:</div>
    <div class="col-md-9">{{ $tx_data->memo }}</div>
</div>
@endif