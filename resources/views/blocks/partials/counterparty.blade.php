<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Ledger Hash:</div>
    <div class="col-md-9">{{ $block->ledger_hash }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx List Hash:</div>
    <div class="col-md-9">{{ $block->txlist_hash }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Messages Hash:</div>
    <div class="col-md-9">{{ $block->messages_hash }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fees:</div>
    <div class="col-md-9">{{ fromSatoshi($fee) }} BTC @if($fee_usd) (${{ number_format(fromSatoshi($fee_usd), 2) }}) @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Size:</div>
    <div class="col-md-9">{{ number_format($size) }} bytes @if($block->size) ({{ number_format($size / $block->size * 100, 2) }}%) @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Weight:</div>
    <div class="col-md-9">{{ number_format($weight) }} weight units @if($block->weight) ({{ number_format($weight / $block->weight * 100, 2) }}%) @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Transactions:</div>
    <div class="col-md-9">{{ count($transactions) }} @if($block->tx_count) ({{ number_format(count($transactions) / $block->tx_count * 100, 2) }}%) @endif</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Messages:</div>
    <div class="col-md-9">{{ $block->messages_count }}</div>
</div>