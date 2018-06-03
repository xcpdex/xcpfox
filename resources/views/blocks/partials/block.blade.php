<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Block Hash:</div>
    <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $block->block_hash])) }}">{{ $block->block_hash }}</a></div>
</div>
@if($block->next_block_hash)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Next Block Hash:</div>
    <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $block->next_block_hash])) }}">{{ $block->next_block_hash }}</a></div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Previous Block Hash:</div>
    @if($block->previous_block_hash === '0000000000000001233c7a200fcd89f5e7cab4b5b4b0c96e447ce25e0bd3ddb9')
    <div class="col-md-9">{{ $block->previous_block_hash }}</div>
    @else
    <div class="col-md-9"><a href="{{ url(route('blocks.show', ['block' => $block->previous_block_hash])) }}">{{ $block->previous_block_hash }}</a></div>
    @endif
</div>
@if($block->processed_at)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Merkle Root:</div>
    <div class="col-md-9">{{ $block->merkle_root }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $block->confirmed_at->toDayDateTimeString() }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Difficulty:</div>
    <div class="col-md-9">{{ number_format($block->difficulty) }}</div>
</div>
@if($block->processed_at)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Size:</div>
    <div class="col-md-9">{{ number_format($block->size) }} bytes</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Weight:</div>
    <div class="col-md-9">{{ number_format($block->weight) }} weight units</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Transactions:</div>
    <div class="col-md-9">{{ number_format($block->tx_count) }}</div>
</div>
@endif