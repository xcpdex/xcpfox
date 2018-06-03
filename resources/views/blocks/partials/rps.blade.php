@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Possible Moves:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->possible_moves }}
    </div>
    <div class="col-md-5 mb-2">
        <b>Wager:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->wager_normalized }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif