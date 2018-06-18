<div class="row">
    <div class="col-md-8">
        <chart
            source="{{ url(route('api.charts.assets.activeAddresses', ['asset_name' => $asset->asset_name, 'group_by' => 'month'])) }}"
            title="Active Addresses ({{ $asset->display_name }})"
            yaxis="Addresses"
            group_by="month"
            type="column"
            cumulative="false"
        >
        </chart>
    </div>
    <div class="col-md-4">
        <br class="d-block d-md-none" />
        <list-addresses
            source="{{ url(route('api.charts.assets.mostActiveAddresses', ['asset_name' => $asset->asset_name])) }}"
            title="Most Active"
            ranking="Actions"
        >
        </list-addresses>
    </div>
</div>