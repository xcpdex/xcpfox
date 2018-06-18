@if(in_array($asset->asset_name, ['BTC', 'XCP', 'PEPECASH', 'BITCRYSTALS', 'FLDC', 'DATABITS', 'TRIGGERS']))
<?php
if ($asset->asset_name === 'BITCRYSTALS'){
    $ticker = 'BCY';
}elseif($asset->asset_name === 'DATABITS'){
    $ticker = 'DTB';
}elseif($asset->asset_name === 'TRIGGERS'){
    $ticker = 'TRIG';
}else{
    $ticker = $asset->asset_name;
}
?>
<div class="card mt-4">
    <div class="card-header font-weight-bold">
        Market History
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <chart-market
                    source="https://coincap.io/history/{{ $ticker }}"
                    title="{{ $ticker }} Charts"
                >
                </chart-market>
            </div>
            <div class="col-md-4">
                <br class="d-block d-md-none" />
                <market-history
                    source="https://coincap.io/history/{{ $ticker }}"
                >
                </market-history>
            </div>
        </div>
    </div>
</div>
@endif