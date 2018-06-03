<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Source:</div>
    <div class="col-md-9">{{ $tx_data->source }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Timestamp:</div>
    <div class="col-md-9">{{ \Carbon\Carbon::createFromTimestamp($tx_data->timestamp)->toDayDateTimeString() }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Text:</div>
    <div class="col-md-9">{{ $tx_data->text }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Value:</div>
    <div class="col-md-9">{{ $tx_data->value }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Locked:</div>
    <div class="col-md-9">{{ $tx_data->locked ? 'Yes' : 'No' }}</div>
</div>