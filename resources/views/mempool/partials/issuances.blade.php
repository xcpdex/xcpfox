<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset Name:</div>
    <div class="col-md-9"><a href="{{ url(route('assets.show', ['asset' => $tx_data->asset_longname ? $tx_data->asset_longname : $tx_data->asset])) }}">{{ $tx_data->asset_longname ? $tx_data->asset_longname : $tx_data->asset }}</a></div>
</div>
@if($tx_data->transfer)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Event:</div>
    <div class="col-md-9">Transfer</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Destination:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->issuer])) }}">{{ $tx_data->issuer }}</a></div>
</div>
@elseif($tx_data->locked)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Event:</div>
    <div class="col-md-9">Lock Issuance</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
@elseif(! \App\Asset::find($tx_data->asset))
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Event:</div>
    <div class="col-md-9">Registration <span class="text-muted">({{ number_format(fromSatoshi($tx_data->fee_paid), 8) }} XCP)</span></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ number_format($tx_data->divisible ? fromSatoshi($tx_data->quantity) : $tx_data->quantity, 8) }} <span class="text-muted">({{ $tx_data->divisible ? 'Divisible' : 'Not Divisible' }})</span></div>
</div>
@if($tx_data->description)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Description:</div>
    <div class="col-md-9">{{ $tx_data->description }}</div>
</div>
@endif
@if($tx_data->callable)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Call Price:</div>
    <div class="col-md-9">{{ $tx_data->call_price }} XCP</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Call Date:</div>
    <div class="col-md-9">{{ \Carbon\Carbon::createFromTimestamp($tx_data->call_date)->toDayDateTimeString() }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
@elseif($tx_data->quantity)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Event:</div>
    <div class="col-md-9">Increase Supply</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">+{{ number_format($tx_data->divisible ? fromSatoshi($tx_data->quantity) : $tx_data->quantity, 8) }} <span class="text-muted">({{ $tx_data->divisible ? 'Divisible' : 'Not Divisible' }})</span></div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
@elseif($tx_data->description)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Event:</div>
    <div class="col-md-9">Update Description</div>
</div>
@if($tx_data->description)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Description:</div>
    <div class="col-md-9">{{ $tx_data->description }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>
@endif