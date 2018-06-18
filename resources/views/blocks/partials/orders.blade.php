@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Buy:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->get_quantity_normalized }} <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->getAssetModel->display_name])) }}">{{ $transaction->relatedModel->getAssetModel->display_name }}</a>
    </div>
    <div class="col-md-5 mb-2">
        <b>Sell:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->give_quantity_normalized }} <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->giveAssetModel->display_name])) }}">{{ $transaction->relatedModel->giveAssetModel->display_name }}</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif