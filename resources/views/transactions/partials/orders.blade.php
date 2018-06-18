@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Buying:</div>
    <div class="col-md-9">{{ number_format($tx_data->get_quantity_normalized, 8) }} <a href="{{ url(route('assets.show', ['asset' => $tx_data->getAssetModel->display_name])) }}">{{ $tx_data->getAssetModel->display_name }}</a> @if($tx_data->get_quantity !== $tx_data->get_remaining && $tx_data->get_remaining > 0) <span class="text-muted">({{ number_format($tx_data->get_remaining_normalized, 8) }} remaining)</span> @endif </div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Selling:</div>
    <div class="col-md-9">{{ number_format($tx_data->give_quantity_normalized, 8) }} <a href="{{ url(route('assets.show', ['asset' => $tx_data->giveAssetModel->display_name])) }}">{{ $tx_data->giveAssetModel->display_name }}</a> @if($tx_data->give_quantity !== $tx_data->give_remaining && $tx_data->give_remaining > 0) <span class="text-muted">({{ number_format($tx_data->give_remaining_normalized, 8)  }} remaining)</span> @endif </div>
</div>
@else
<?php $get_asset = \App\Asset::whereAssetName($tx_data->get_asset)->first(); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Buying:</div>
    <div class="col-md-9">{{ $get_asset && $get_asset->divisible ? number_format(fromSatoshi($tx_data->get_quantity), 8) : number_format($tx_data->get_quantity, 8) }} <a href="{{ url(route('assets.show', ['asset' => $get_asset->display_name])) }}">{{ $get_asset->display_name }}</a> @if($tx_data->get_quantity !== $tx_data->get_remaining && $tx_data->get_remaining > 0) <span class="text-muted">({{ $get_asset && $get_asset->divisible ? number_format(fromSatoshi($tx_data->get_remaining), 8) : number_format($tx_data->get_remaining, 8) }} remaining)</span> @endif </div>
</div>
<?php $give_asset = \App\Asset::whereAssetName($tx_data->give_asset)->first(); ?>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Selling:</div>
    <div class="col-md-9">{{ $give_asset && $give_asset->divisible ? number_format(fromSatoshi($tx_data->give_quantity), 8) : number_format($tx_data->give_quantity, 8) }} <a href="{{ url(route('assets.show', ['asset' => $give_asset->display_name])) }}">{{ $give_asset->display_name }}</a> @if($tx_data->give_quantity !== $tx_data->give_remaining && $tx_data->give_remaining > 0) <span class="text-muted">({{ $give_asset && $give_asset->divisible ? number_format(fromSatoshi($tx_data->give_quantity), 8) : number_format($tx_data->give_quantity, 8) }} remaining)</span> @endif </div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $transaction->confirmed_at->toDayDateTimeString() }}</div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9"><i class="fa {{ $tx_data->status !== 'cancelled' ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> <span class="text-capitalize">{{ $tx_data->status }}</span> @if($tx_data->status === 'open') <span class="text-muted">({{ $tx_data->expiration - ($tx_data->expire_index - \Cache::get('block_height')) }}/{{ $tx_data->expiration }} blocks)</span> @endif</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9"><i class="fa {{ $transaction->valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> {{ $transaction->valid ? 'Valid' : ucfirst($tx_data->status) }}</div>
</div>
@endif