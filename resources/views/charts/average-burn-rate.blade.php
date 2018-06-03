@extends('layouts.app')

@section('title', 'Average Burn Rate')

@section('header')
<link rel="canonical" href="{{ url(route('charts.average-burn-rate')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        var counts = new Array();
        var rates = new Array();
        $.getJSON('{{ url(route('api.charts.average-burn-rate')) }}', function(data) {
            for (i = 0; i < data.data.length; i++) {
                counts.push([data.data[i][0], data.data[i][2]]);
                rates.push([data.data[i][0], data.data[i][1]]);
            }
            $('#chart').highcharts({
                chart: {
                    zoomType: 'xy'
                },
                boost: {
                    useGPUTranslations: true
                },
                title: {
                    text: 'Average Burn Rate'
                },
                subtitle: {
                    text: 'Source: XCPFOX.com'
                },
                xAxis: [{
                    type: 'datetime',
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value} XCP',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Burn Rate',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }, { // Secondary yAxis
                    title: {
                        text: 'Burns (Count)',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 120,
                    verticalAlign: 'top',
                    y: 100,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: [{
                    name: 'Burns',
                    type: 'column',
                    yAxis: 1,
                    data: counts,
                }, {
                    name: 'Burn Rate',
                    type: 'spline',
                    data: rates,
                    tooltip: {
                        valuePrefix: '1 BTC = ',
                        valueSuffix: ' XCP'
                    }
                }]
            });
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div id="chart" style="height: 600px"></div>
</div>
@endsection