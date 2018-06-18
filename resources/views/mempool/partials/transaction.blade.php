<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Tx Hash:</div>
    <div class="col-md-9"><a href="https://bitcoinchain.com/block_explorer/tx/{{ $mempool->tx_hash }}" target="_blank">{{ $mempool->tx_hash }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">First Seen:</div>
    <div class="col-md-9">{{ \Carbon\Carbon::createFromTimestamp($mempool->timestamp)->diffForHumans() }}</div>
</div>