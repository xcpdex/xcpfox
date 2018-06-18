<ul class="pagination mt-1 float-right">
    @if($prev_block)
    <li class="page-item"><a href="{{ url(route('blocks.show', ['block_hash' => $prev_block->block_hash])) }}" rel="prev" class="page-link">&laquo;</a></li>
    @else
    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    @endif
    @if($next_block)
    <li class="page-item"><a href="{{ url(route('blocks.show', ['block_hash' => $next_block->block_hash])) }}" rel="next" class="page-link">&raquo;</a></li>
    @else
    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
    @endif
</ul>