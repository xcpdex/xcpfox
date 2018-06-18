<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Bet Type:</div>
    <div class="col-md-9">{{ getBetType($tx_data->bet_type) }}</div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager:</div>
    <div class="col-md-9">{{ number_format($tx_data->wager_quantity_normalized, 8) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a> @if($tx_data->wager_quantity !== $tx_data->wager_remaining && $tx_data->wager_remaining > 0) <span class="text-muted">({{ number_format($tx_data->wager_remaining_normalized, 8) }} remaining)</span> @endif </div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager:</div>
    <div class="col-md-9">{{ number_format($tx_data->counterwager_quantity_normalized, 8) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a> @if($tx_data->counterwager_quantity !== $tx_data->counterwager_remaining && $tx_data->counterwager_remaining > 0) <span class="text-muted">({{ number_format($tx_data->counterwager_remaining_normalized, 8) }} remaining)</span> @endif </div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager:</div>
    <div class="col-md-9">{{ number_format(fromSatoshi($tx_data->wager_quantity), 8) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a> @if($tx_data->wager_quantity !== $tx_data->wager_remaining && $tx_data->wager_remaining > 0) <span class="text-muted">({{ number_format(fromSatoshi($tx_data->wager_remaining), 8) }} remaining)</span> @endif </div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager:</div>
    <div class="col-md-9">{{ number_format(fromSatoshi($tx_data->counterwager_quantity), 8) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a> @if($tx_data->counterwager_quantity !== $tx_data->counterwager_remaining && $tx_data->counterwager_remaining > 0) <span class="text-muted">({{ number_format(fromSatoshi($tx_data->counterwager_remaining), 8) }} remaining)</span> @endif </div>
</div>
@endif
@if($tx_data->bet_type === 2 || $tx_data->bet_type === 3)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Target Value:</div>
    <div class="col-md-9">{{ $tx_data->target_value }}</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Leverage:</div>
    <div class="col-md-9">{{ number_format($tx_data->leverage / 5040, 8) }}x</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Feed Address:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->feed_address])) }}">{{ $tx_data->feed_address }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee %:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->fee_fraction_int) }}%</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $transaction->confirmed_at->toDayDateTimeString() }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Deadline:</div>
    <div class="col-md-9">{{ \Carbon\Carbon::createFromTimestamp($tx_data->deadline)->toDayDateTimeString() }}</div>
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