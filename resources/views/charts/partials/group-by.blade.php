<div class="row">
    <div class="d-none d-md-inline col-md-2 col-lg-1 offset-md-3 mt-4 text-right">
        <h5 class="mt-1">Group:</h5>
    </div>
    <div class="col-md-4 col-lg-5 mt-4">
        <div class="btn-group d-flex" role="group" aria-label="Group">
            @foreach(['date', 'month', 'year'] as $group_by_option)
            <a href="{{ url(route($route, ['group_by' => $group_by_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $group_by === $group_by_option ? ' active' : '' }}">{{ ucfirst($group_by_option) }}</a>
            @endforeach
        </div>
    </div>
</div>