<div class="row">
    <div class="col-md-8">
        <chart
            source="{{ url(route('api.charts.assets.highestBalances', ['asset_name' => $asset->asset_name, 'group_by' => 'month', 'take' => 20])) }}"
            title="Top Holders ({{ $asset->display_name }})"
            yaxis="{{ $asset->display_name }}"
            type="column"
            cumulative="false"
        >
        </chart>
    </div>
    <div class="col-md-4">
        <br class="d-block d-md-none" />
        <list-addresses
            source="{{ url(route('api.charts.assets.highestBalances', ['asset_name' => $asset->asset_name])) }}"
            title="Top Holders"
            ranking="Amount"
        >
        </list-addresses>
    </div>
</div>