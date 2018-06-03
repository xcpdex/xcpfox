@if($transaction->valid)
<div class="row">
    @if($transaction->relatedModel->value)
    <div class="col-md-5 mb-2">
        <b>Text:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->text }}
    </div>
    <div class="col-md-5 mb-2">
        <b>Value:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->value }}
    </div>
    @else
    <div class="col-12 mb-2">
        <b>Text:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->text }}
    </div>
    @endif
</div>
@else
    @include('blocks.partials.invalid')
@endif