@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Wager:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->wager_quantity_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a>
    </div>
    <div class="col-md-5 mb-2">
        <b>Counterwager:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->counterwager_quantity_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif