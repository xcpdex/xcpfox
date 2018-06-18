<div class="row">
    <div class="col-md-8">
        <chart
            source="{{ url(route('api.charts.assets.uniqueTrades', ['asset_name' => $asset->asset_name, 'group_by' => 'month'])) }}"
            title="Trade Count ({{ $asset->display_name }})"
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
            source="{{ url(route('api.charts.assets.topTraders', ['asset_name' => $asset->asset_name])) }}"
            title="Most Trades"
            ranking="Total"
        >
        </list-addresses>
    </div>
</div>