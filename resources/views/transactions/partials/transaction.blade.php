<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx Hash:</div>
    <div class="col-md-9"><a href="https://bitcoinchain.com/block_explorer/tx/{{ $transaction->tx_hash }}" target="_blank">{{ $transaction->tx_hash }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Block Index:</div>
    <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $transaction->block_index])) }}">{{ number_format($transaction->block_index) }}</a></div>
</div>
@if($transaction->processed_at)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">BTC Sent:</div>
    <div class="col-md-9">{{ fromSatoshi($transaction->quantity) }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a> @if($transaction->quantity) <span class="text-muted">(${{ fromSatoshi($transaction->quantity_usd) }} USD)</span> @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx Fee:</div>
    <div class="col-md-9">{{ fromSatoshi($transaction->fee) }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a> @if($transaction->fee) <span class="text-muted">(${{ fromSatoshi($transaction->fee_usd) }} USD)</span> @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx Size:</div>
    <div class="col-md-9">{{ number_format($transaction->vsize) }} bytes <span class="text-muted">({{ number_format($transaction->vsize * 4) }} weight units)</span></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee Rate:</div>
    <div class="col-md-9">{{ number_format($transaction->fee / $transaction->vsize) }} sats/byte</div>
</div>
@endif