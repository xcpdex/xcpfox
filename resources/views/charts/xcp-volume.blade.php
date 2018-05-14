@extends('layouts.app')

@section('title', 'XCP Volume (USD)')

@section('header')
<link rel="canonical" href="{{ url(route('charts.xcp-volume')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $.getJSON('https://coincap.io/history/XCP', function(data) {
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
                    text: "XCP Volume (USD)"
                },
                subtitle: {
                    text: "Source: CoinCap.io"
                },
                xAxis: {
                    type: 'datetime',
                },
                yAxis: {
                    title: {
                        text: "Dollars"
                    }
                },
                series: [{
                    name: 'Volume USD',
                    data: data.volume
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
                <a href="{{ url(route('charts.xcp-price', ['chart' => $chart])) }}" role="button" class="btn btn-sm btn-outline-primary w-100">Price</a>
                <a href="{{ url(route('charts.xcp-market-cap', ['chart' => $chart])) }}" role="button" class="btn btn-sm btn-outline-primary w-100">Market Cap</a>
                <a href="{{ url(route('charts.xcp-volume', ['chart' => $chart])) }}" role="button" class="btn btn-sm btn-outline-primary w-100 active">Volume</a>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                @foreach(['area', 'line', 'column'] as $chart_option)
                <a href="{{ url(route('charts.xcp-volume', ['chart' => $chart_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart === $chart_option ? ' active' : '' }}">{{ ucfirst($chart_option) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection