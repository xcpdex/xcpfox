@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">@if($tx_data->destinationAddress && $tx_data->destinationAddress->burn) <i class="fa fa-fire text-danger" title="Burn"></i> @endif {{ number_format($tx_data->quantity_normalized, 8) }} <a href="{{ url(route('assets.show', ['asset' => $tx_data->assetModel->display_name])) }}">{{ $tx_data->assetModel->display_name }}</a></div>
</div>
@elseif($asset = \App\Asset::find($tx_data->asset))
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ $asset->divisible ? number_format(fromSatoshi($tx_data->quantity), 8) : number_format($tx_data->quantity) }} <a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ $tx_data->quantity }} <a href="{{ url(route('assets.show', ['asset' => $tx_data->asset])) }}">{{ $tx_data->asset }}</a></div>
</div>
@endif
@if(isset($tx_data->memo) && $tx_data->memo)
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
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $transaction->confirmed_at->toDayDateTimeString() }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9"><i class="fa {{ $transaction->valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> {{ $transaction->valid ? 'Valid' : ucfirst($tx_data->status) }}</div>
</div>