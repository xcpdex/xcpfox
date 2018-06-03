@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Burned:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->burned_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a>
    </div>
    <div class="col-md-5 mb-2">
        <b>Earned:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->earned_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif