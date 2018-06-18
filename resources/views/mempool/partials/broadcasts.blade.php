@if($tx_data->locked)
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Locked:</div>
    <div class="col-md-9">{{ $tx_data->locked ? 'Yes' : 'No' }}</div>
</div>
@else
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Text:</div>
    <div class="col-md-9">{{ $tx_data->text }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Value:</div>
    <div class="col-md-9">{{ $tx_data->value }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Fee %:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->fee_fraction_int) }}%</div>
</div>
@endif
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9"><a href="{{ url(route('addresses.show', ['address' => $tx_data->source])) }}">{{ $tx_data->source }}</a></div>
</div>