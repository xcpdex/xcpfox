<span class="badge {{ getBadgeColor(getTitleFromType($transaction->type)) }} text-white">
    {{ getTitleFromType($transaction->type) }}
</span>
<span class="ml-2">
    <a href="{{ url(route('transactions.show', ['tx_hash' => $transaction->tx_hash])) }}">
        <span class="d-inline d-md-none">
            #{{ $transaction->tx_index }}
        </span>
        <span class="d-none d-md-inline">
            {{ $transaction->tx_hash }}
        </span>
    </a>
</span>