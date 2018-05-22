@extends('layouts.app')

@section('title', 'Message Categories')

@section('header')
<link rel="canonical" href="{{ url(route('charts.message-categories')) }}" />

<!-- Charts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/boost.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    $(function () {
        $.getJSON('{{ url(route('api.charts.message-categories')) }}', function(data) {
            $('#chart').highcharts({
                chart: {
                    type: "pie",
                },
                boost: {
                    useGPUTranslations: true
                },
                title: {
                    text: "Message Categories"
                },
                subtitle: {
                    text: "Source: XCPFOX.com"
                },
                series: [{
                    name: 'Messages',
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