<div class="row">
    <div class="col-md-8">
        <chart
            source="{{ url(route('api.charts.assets.tokensTraded', ['asset_name' => $asset->asset_name, 'group_by' => 'month'])) }}"
            title="Total Traded ({{ $asset->display_name }})"
            yaxis="{{ $asset->display_name }}"
            group_by="month"
            type="column"
            cumulative="false"
        >
        </chart>
    </div>
    <div class="col-md-4">
        <br class="d-block d-md-none" />
        <list-addresses
            source="{{ url(route('api.charts.assets.topTradersQuantity', ['asset_name' => $asset->asset_name])) }}"
            title="Most Traded"
            ranking="Total"
        >
        </list-addresses>
    </div>
</div>