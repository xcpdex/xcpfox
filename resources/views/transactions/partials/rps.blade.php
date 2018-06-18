<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Possible Moves:</div>
    <div class="col-md-9">{{ $tx_data->possible_moves }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->wager) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Move Random Hash:</div>
    <div class="col-md-9">{{ $tx_data->move_random_hash }}</div>
</div>
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
    <div class="col-md-9"><i class="fa {{ $tx_data->status !== 'expired' ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> <span class="text-capitalize">{{ $tx_data->status }}</span> @if($tx_data->status === 'open') <span class="text-muted">({{ $tx_data->expiration - ($tx_data->expire_index - \Cache::get('block_height')) }}/{{ $tx_data->expiration }} blocks)</span> @endif</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9"><i class="fa {{ $transaction->valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> {{ $transaction->valid ? 'Valid' : ucfirst($tx_data->status) }}</div>
</div>
@endif