@extends('layouts.app')

@section('title', 'Transaction Count by Type')

@section('header')
<link rel="canonical" href="{{ url(route('charts.total-fees')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $.getJSON('{{ url(route('api.charts.txs-by-type', ['group_by' => $group_by])) }}', function(data) {
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
                plotOptions: {
                    area: {
                        stacking: 'normal',
                    }
                },
                title: {
                    text: "Transaction Count by Type"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                xAxis: {
                    type: '{{ $group_by === 'date' ? 'datetime' : 'category' }}',
                },
                yAxis: {
                    title: {
                        text: "Count"
                    }
                },
                series: [{
                    name: 'bets',
                    data: data[0].bets
                },{
                    name: 'broadcasts',
                    data: data[1].broadcasts
                },{
                    name: 'btcpays',
                    data: data[2].btcpays
                },{
                    name: 'burns',
                    data: data[3].burns
                },{
                    name: 'cancels',
                    data: data[4].cancels
                },{
                    name: 'destructions',
                    data: data[5].destructions
                },{
                    name: 'dividends',
                    data: data[6].dividends
                },{
                    name: 'issuances',
                    data: data[7].issuances
                },{
                    name: 'orders',
                    data: data[8].orders
                },{
                    name: 'rps',
                    data: data[9].rps
                },{
                    name: 'rpsresolves',
                    data: data[10].rpsresolves
                },{
                    name: 'sends',
                    data: data[11].sends
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
        <div class="col-md-4 offset-md-2 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Group">
                @foreach(['date', 'month', 'year'] as $group_by_option)
                <a href="{{ url(route('charts.txs-by-type', ['chart' => $chart, 'group_by' => $group_by_option])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $group_by === $group_by_option ? ' active' : '' }}">{{ ucfirst($group_by_option) }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="btn-group d-flex" role="group" aria-label="Chart">
                @foreach(['area', 'line', 'column'] as $chart_option)
                <a href="{{ url(route('charts.txs-by-type', ['chart' => $chart_option, 'group_by' => $group_by])) }}" role="button" class="btn btn-sm btn-outline-primary w-100{{ $chart === $chart_option ? ' active' : '' }}">{{ ucfirst($chart_option) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection