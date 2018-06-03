<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Feed Address:</div>
    <div class="col-md-9">{{ $tx_data->feed_address }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Bet Type:</div>
    <div class="col-md-9">{{ getBetType($tx_data->bet_type) }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Deadline:</div>
    <div class="col-md-9">{{ $tx_data->deadline }}</div>
</div>
@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager Quantity:</div>
    <div class="col-md-9">{{ $tx_data->wager_quantity_normalized }} (${{ $tx_data->wager_quantity_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager Remaining:</div>
    <div class="col-md-9">{{ $tx_data->wager_remaining_normalized }} (${{ $tx_data->wager_remaining_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager Quantity:</div>
    <div class="col-md-9">{{ $tx_data->counterwager_quantity_normalized }} (${{ $tx_data->counterwager_quantity_usd_normalized }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager Remaining:</div>
    <div class="col-md-9">{{ $tx_data->counterwager_remaining_normalized }} (${{ $tx_data->counterwager_remaining_usd_normalized }})</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager Quantity:</div>
    <div class="col-md-9">{{ $tx_data->wager_quantity }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager Remaining:</div>
    <div class="col-md-9">{{ $tx_data->wager_remaining }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager Quantity:</div>
    <div class="col-md-9">{{ $tx_data->counterwager_quantity }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Counterwager Remaining:</div>
    <div class="col-md-9">{{ $tx_data->counterwager_remaining }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Target Value:</div>
    <div class="col-md-9">{{ $tx_data->target_value }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Leverage:</div>
    <div class="col-md-9">{{ $tx_data->leverage }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee Fraction Int:</div>
    <div class="col-md-9">{{ $tx_data->fee_fraction_int }}</div>
</div>
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