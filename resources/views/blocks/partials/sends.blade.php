@if($transaction->valid)
<div class="row">
    <div class="col-12 mb-2">
        <b>Send:</b>
        <br class="d-block d-lg-none" />
        {{ $transaction->relatedModel->quantity_normalized }}
        <a href="{{ url(route('assets.show', ['asset' => $transaction->relatedModel->asset])) }}">{{ $transaction->relatedModel->asset }}</a>
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif