<div class="row">
    <div class="col-12 mt-4 text-center">
        @if($prev_block)
        <a href="{{ url(route('blocks.show', ['block_hash' => $prev_block->block_hash])) }}" class="btn btn-outline-success mr-2" title="Go to block with Counterparty data">&laquo; {{ $next_block ? 'Prev' : 'Previous Block' }}</a>
        @endif
        @if($next_block)
        <a href="{{ url(route('blocks.show', ['block_hash' => $next_block->block_hash])) }}" class="btn btn-outline-success" title="Go to block with Counterparty data">{{ $prev_block ? 'Next' : 'Next Block' }} &raquo;</a>
        @endif
    </div>
</div>