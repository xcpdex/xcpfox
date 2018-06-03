@if($transaction->valid)
<div class="row">
    <div class="col-md-5 mb-2">
        <b>Move:</b> <br class="d-block d-lg-none" /> {{ $transaction->relatedModel->move }}
    </div>
</div>
@else
    @include('blocks.partials.invalid')
@endif