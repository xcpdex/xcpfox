@if($transaction->valid)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset:</div>
    <div class="col-md-9">{{ $tx_data->display_name }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ $tx_data->quantity_normalized }}</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Asset:</div>
    <div class="col-md-9">{{ $tx_data->asset_longname ? $tx_data->asset_longname : $tx_data->asset }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Quantity:</div>
    <div class="col-md-9">{{ $tx_data->divisible ? fromSatoshi($tx_data->quantity) : $tx_data->quantity }}</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Divisible:</div>
    <div class="col-md-9">{{ $tx_data->divisible ? 'Yes' : 'No' }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Locked:</div>
    <div class="col-md-9">{{ $tx_data->locked ? 'Yes' : 'No' }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Transfer:</div>
    <div class="col-md-9">{{ $tx_data->transfer ? 'Yes' : 'No' }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Callable:</div>
    <div class="col-md-9">{{ $tx_data->callable ? 'Yes' : 'No' }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Call Date:</div>
    <div class="col-md-9">{{ $tx_data->call_date }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Call Price:</div>
    <div class="col-md-9">{{ $tx_data->call_price }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Description:</div>
    <div class="col-md-9">{{ $tx_data->description }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Issuer:</div>
    <div class="col-md-9">{{ $tx_data->issuer }}</div>
</div>