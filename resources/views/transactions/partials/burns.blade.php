<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">BTC Burned:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->burned) }} <a href="{{ url(route('assets.show', ['asset' => 'BTC'])) }}">BTC</a> <span class="text-muted">(1 BTC = {{ $tx_data->earned / $tx_data->burned }} XCP)</span></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">XCP Earned:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->earned) }} <a href="{{ url(route('assets.show', ['asset' => 'XCP'])) }}">XCP</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ $transaction->confirmed_at->toDayDateTimeString() }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9"><i class="fa {{ $transaction->valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i> {{ $transaction->valid ? 'Valid' : ucfirst($tx_data->status) }}</div>
</div>