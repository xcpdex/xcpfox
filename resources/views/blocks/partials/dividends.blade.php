@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Asset:</b> <br class="d-block d-lg-none" /> <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->asset])) }}">{{ $transaction->relatedModel->asset }}</a>
    </div>
    <div class="col-md-5 mb-2">
        <b>Dividend:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->quantity_per_unit_normalized }} <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->dividend_asset])) }}">{{ $transaction->relatedModel->dividend_asset }}</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif