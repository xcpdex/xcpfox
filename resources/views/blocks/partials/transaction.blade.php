@include('blocks.partials.' . $transaction->type)
<div class="row">
    <div class="{{ $transaction->destination || isset(json_decode($transaction->message['bindings'])->destination) ? 'col-md-5' : 'col-md-10 col-lg-5' }} mb-2">
        <b>From:</b> <br class="d-block d-lg-none" /> <a href="{{ url(route('addresses.show', ['address' => $transaction->source])) }}">{{ $transaction->source }}</a>
    </div>
    @if($transaction->destination)
    <div class="col-md-5 mb-2">
        <b>To:</b> <br class="d-block d-lg-none" /> <a href="{{ url(route('addresses.show', ['address' => $transaction->destination])) }}">{{ $transaction->destination }}</a>
    </div>
    @elseif(isset(json_decode($transaction->message['bindings'])->destination))
    <div class="col-md-5 mb-2">
        <b>To:</b> <br class="d-block d-lg-none" /> <a href="{{ url(route('addresses.show', ['address' => json_decode($transaction->message['bindings'])->destination])) }}">{{ json_decode($transaction->message['bindings'])->destination }}</a>
    </div>
    @endif
    <div class="col-md-2 {{ $transaction->destination || isset(json_decode($transaction->message['bindings'])->destination) ? '' : 'offset-md-5' }} mb-2 d-none d-lg-inline">
        <b>Fee:</b> <br class="d-block d-lg-none" /> <span title="{{ $transaction->fee_usd_normalized }} USD">{{ $transaction->fee_normalized }} BTC</span>
    </div>
</div>