<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">Burn Rate:</div>
    <div class="col-md-9">1 BTC = {{ $tx_data->earned / $tx_data->burned }} XCP</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">BTC Burned:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->burned) }} BTC (${{ $tx_data->burned_usd }})</div>
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold">XCP Earned:</div>
    <div class="col-md-9">{{ fromSatoshi($tx_data->earned) }} XCP (${{ $tx_data->earned_usd }})</div>
</div>