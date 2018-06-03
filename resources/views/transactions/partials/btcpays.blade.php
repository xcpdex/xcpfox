@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Amount:</div>
    <div class="col-md-9">{{ $tx_data->btc_amount_normalized }} BTC (${{ $tx_data->btc_amount_usd_normalized }})</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Amount:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->btc_amount)}} BTC</div>
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
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Order Match ID:</div>
    <div class="col-md-9">{{ $tx_data->order_match_id }}</div>
</div>