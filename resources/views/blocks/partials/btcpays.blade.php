@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Amount:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->btc_amount_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif