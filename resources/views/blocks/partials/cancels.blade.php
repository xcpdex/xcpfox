@if($transaction->valid)
<div class="row">
    <div class="col-12 mb-2">
        <b>Order:</b> <br class="d-block d-lg-none" /> <a href="{{ url(route('transactions.show', ['tx_hash' => $transaction->relatedModel->offer_hash])) }}">{{ $transaction->relatedModel->offer_hash }}</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif