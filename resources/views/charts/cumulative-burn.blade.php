@extends('layouts.app')

@section('title', 'Cumulative Bitcoin Burn')

@section('header')
<link rel="canonical" href="{{ url(route('charts.cumulative-burn')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        var processed_json = new Array();
        var running_total = 0;
        $.getJSON('{{ url(route('api.charts.total-burn')) }}', function(data) {
            for (i = 0; i < data.data.length; i++) {
                running_total += data.data[i][1];
                processed_json.push([data.data[i][0], running_total]);
            }
            $('#chart').highcharts({
                chart: {
                    type: "{{ $chart }}",
                    zoomType: "x",
                    panning: true,
                    panKey: "shift"
                },
                boost: {
                    useGPUTranslations: true
                },
                title: {
                    text: "Cumulative Bitcoin Burn"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                xAxis: {
                    type: 'datetime',
                },
                yAxis: {
                    title: {
                        text: "Bitcoin"
                    }
                },
                series: [{
                    name: 'Total BTC',
                    data: processed_json
                }],
            }); 
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div id="chart" style="height: 600px"></div>
    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                <a href="{{ url(route('charts.cumulative-burn', ['chart' => $chart])) }}" role="button" class="btn btn-sm btn-outline-primary w-100 active">BTC</a>
                <a href="{{ url(route('charts.cumulative-burn-usd', ['chart' => $chart])) }}" role="button" class="btn btn-sm btn-outline-primary w-100">USD</a>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                @foreach(['area', 'line', 'column'] as $chart_option)
                <a href="{{ url(route('charts.cumulative-burn', ['chart' => $chart_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart === $chart_option ? ' active' : '' }}">{{ ucfirst($chart_option) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection