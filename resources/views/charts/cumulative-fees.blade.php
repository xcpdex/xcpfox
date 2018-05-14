@extends('layouts.app')

@section('title', 'Cumulative Counterparty Fees')

@section('header')
<link rel="canonical" href="{{ url(route('charts.cumulative-fees')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        var processed_json = new Array();
        var running_total = 0;
        $.getJSON('{{ url(route('api.charts.total-fees', ['group_by' => $group_by])) }}', function(data) {
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
                    text: "Cumulative Counterparty Fees (BTC)"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                xAxis: {
                    type: '{{ $group_by === 'date' ? 'datetime' : 'category' }}',
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
        <div class="col-md-4 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                <a href="{{ url(route('charts.cumulative-fees', ['chart' => $chart, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100 active">BTC</a>
                <a href="{{ url(route('charts.cumulative-fees-usd', ['chart' => $chart, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100">USD</a>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Group">
                @foreach(['date', 'month', 'year'] as $group_by_option)
                <a href="{{ url(route('charts.cumulative-fees', ['chart' => $chart, 'group_by' => $group_by_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $group_by === $group_by_option ? ' active' : '' }}">{{ ucfirst($group_by_option) }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                @foreach(['area', 'line', 'column'] as $chart_option)
                <a href="{{ url(route('charts.cumulative-fees', ['chart' => $chart_option, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart === $chart_option ? ' active' : '' }}">{{ ucfirst($chart_option) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection