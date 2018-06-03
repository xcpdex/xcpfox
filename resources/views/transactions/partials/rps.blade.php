<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Possible Moves:</div>
    <div class="col-md-9">{{ $tx_data->possible_moves }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Wager:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->wager) }} XCP</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Move Random Hash:</div>
    <div class="col-md-9">{{ $tx_data->move_random_hash }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Expiration:</div>
    <div class="col-md-9">{{ $tx_data->expiration }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Expire Index:</div>
    <div class="col-md-9">{{ $tx_data->expire_index }}</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Status:</div>
    <div class="col-md-9">{{ $tx_data->status }}</div>
</div>