<div class="row">
    <div class="d-none d-md-inline col-md-2 col-lg-1 mt-4 text-right">
        <h5 class="mt-1">Group:</h5>
    </div>
    <div class="col-md-4 col-lg-4 mt-4">
        <div class="btn-group d-flex" role="group" aria-label="Group">
            @foreach(['date', 'month', 'year'] as $group_by_option)
            <a href="{{ url(route($route, ['chart_type' => $chart_type, 'group_by' => $group_by_option, 'currency' => $currency])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $group_by === $group_by_option ? ' active' : '' }}">{{ ucfirst($group_by_option) }}</a>
            @endforeach
        </div>
    </div>
    <div class="d-none d-md-inline col-md-2 col-lg-1 mt-4 text-right">
        <h5 class="mt-1">Chart:</h5>
    </div>
    <div class="col-md-4 col-lg-4 mt-4">
        <div class="btn-group d-flex" role="group" aria-label="Chart">
            @foreach(['area', 'line', 'column'] as $chart_type_option)
            <a href="{{ url(route($route, ['chart_type' => $chart_type_option, 'group_by' => $group_by, 'currency' => $currency])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart_type === $chart_type_option ? ' active' : '' }}">{{ ucfirst($chart_type_option) }}</a>
            @endforeach
        </div>
    </div>
    <div class="col-8 col-md-4 offset-md-2 col-lg-2 offset-lg-0 mt-4">
        <div class="btn-group d-flex" role="group" aria-label="Currency">
            <a href="{{ url(route($route, ['chart_type' => $chart_type, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $currency === 'BTC' || $currency === 'XCP' ? ' active' : '' }}">{{ \Route::currentRouteName() === 'charts.registrationFee' ? 'XCP' : 'BTC' }}</a>
            <a href="{{ url(route($route, ['chart_type' => $chart_type, 'group_by' => $group_by, 'currency' => 'USD'])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $currency === 'USD' ? ' active' : '' }}">USD</a>
        </div>
    </div>
</div>