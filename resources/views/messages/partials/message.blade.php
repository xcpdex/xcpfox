<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Category:</div>
    <div class="col-md-9">{{ str_replace('_', ' ', $message_type) }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Command:</div>
    <div class="col-md-9 text-capitalize">{{ $message->command }}</div>
</div>