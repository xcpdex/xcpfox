<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Supply:</div>
    <div class="col-md-9">{{ number_format($asset->issuance_normalized, 8) }} @if($burned_supply > 0) <span class="text-muted">({{ number_format($asset->issuance_normalized - $burned_supply, 8) }})</span> @endif</div>
</div>
@if($burned_supply > 0)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Burned:</div>
    <div class="col-md-9"><i class="fa fa-fire text-danger" title="Burned"></i> {{ number_format($burned_supply, 8) }}</div>
</div>
@endif
@if($asset->owner)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Owner:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->owner])) }}">{{ $asset->owner }}</a></div>
</div>
@endif
@if($asset->issuer !== $asset->owner)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Issuer:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $asset->issuer])) }}">{{ $asset->issuer }}</a></div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Issued:</div>
    <div class="col-md-9">{{ $asset->confirmed_at->toDayDateTimeString() }} @if($asset->asset_name !== 'BTC') <span class="text-muted">(<a href="{{ url(route('transactions.show', ['transaction' => $asset->tx_index])) }}" class="text-muted" target="_blank">#{{ $asset->tx_index }}</a>)</span> @endif </div>
</div>