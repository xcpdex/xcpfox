@extends('layouts.app')

@section('title', 'Transaction Types')

@section('header')
<link rel="canonical" href="{{ url(route('charts.transaction-types')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $.getJSON('{{ url(route('api.charts.transaction-types')) }}', function(data) {
            $('#chart').highcharts({
                chart: {
                    type: "pie",
                },
                boost: {
                    useGPUTranslations: true
                },
                title: {
                    text: "Transaction Types"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                series: [{
                    name: 'Transactions',
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
</div>
@endsection