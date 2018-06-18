@if($message->transaction)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx Hash:</div>
    <div class="col-md-9"><a href="{{ url(route('transactions.show', ['transaction' => $message->transaction->tx_hash])) }}">{{ $message->transaction->tx_hash }}</a></div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Block Index:</div>
    <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $message->block_index])) }}">{{ number_format($message->block_index) }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $message->confirmed_at->toDayDateTimeString() }}</div>
</div>