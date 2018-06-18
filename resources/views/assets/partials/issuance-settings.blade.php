<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Divisible:</div>
    @if($asset->divisible)
    <div class="col-md-9"><i class="fa fa-check-circle text-success"></i> Yes</div>
    @else
    <div class="col-md-9"><i class="fa fa-times-circle text-danger"></i> No</div>
    @endif
</div>
<div class="row mb-2">
    <div class="col-md-3 font-weight-bold font-weight-bold">Locked:</div>
    @if($asset->locked)
    <div class="col-md-9"><i class="fa fa-check-circle text-success"></i> Yes</div>
    @else
    <div class="col-md-9"><i class="fa fa-times-circle text-danger"></i> No</div>
    @endif
</div>