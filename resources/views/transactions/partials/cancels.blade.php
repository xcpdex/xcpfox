<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Order Tx Hash:</div>
    <div class="col-md-9"><a href="{{ url(route('transactions.show', ['tx_hash' => $tx_data->offer_hash])) }}">{{ $tx_data->offer_hash }}</a></div>
</div>