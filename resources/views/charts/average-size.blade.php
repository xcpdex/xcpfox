@extends('layouts.app')

@section('title', 'Average Transaction Size')

@section('header')
<link rel="canonical" href="{{ url(route('charts.average-size')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $.getJSON('{{ url(route('api.charts.average-size', ['group_by' => $group_by])) }}', function(data) {
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
                    text: "Average Transaction Size"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                xAxis: {
                    type: '{{ $group_by === 'date' ? 'datetime' : 'category' }}',
                },
                yAxis: {
                    title: {
                        text: "Bytes"
                    }
                },
                series: [{
                    name: 'Average Bytes',
                    data: data.data
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
            <div class="btn-group d-flex" role="group" aria-label="Group">
                @foreach(['date', 'month', 'year'] as $group_by_option)
                <a href="{{ url(route('charts.average-size', ['chart' => $chart, 'group_by' => $group_by_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $group_by === $group_by_option ? ' active' : '' }}">{{ ucfirst($group_by_option) }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                @foreach(['area', 'line', 'column'] as $chart_option)
                <a href="{{ url(route('charts.average-size', ['chart' => $chart_option, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart === $chart_option ? ' active' : '' }}">{{ ucfirst($chart_option) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection