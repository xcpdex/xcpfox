@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Asset:</b>
        <br class="d-block d-lg-none" />
        <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->asset])) }}">{{ $transaction->relatedModel->asset }}</a>
    </div>
    <div class="col-md-5 mb-2">
        <b>Issuance:</b>
        <br class="d-block d-lg-none" />
        <a href="{{ url(route('transactions.show', ['tx_hash' => $transaction->tx_hash])) }}">{{ $transaction->relatedModel->quantity_normalized }}</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif