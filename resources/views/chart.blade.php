<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Highcharts data from JSON Response</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/fees', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, data[i].fees_usd / 100000000]);
                    }
                 
                    // draw chart
                    $('#fees_usd').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Fees (USD)"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Total"
                        }
                    },
                    series: [{
                        name: 'Fees (USD)',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/fees', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, parseFloat(data[i].fees)]);
                    }
                 
                    // draw chart
                    $('#fees').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Fees"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Total"
                        }
                    },
                    series: [{
                        name: 'Fees',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/transactions', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, data[i].count]);
                    }
                 
                    // draw chart
                    $('#transactions').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Transactions"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Count"
                        }
                    },
                    series: [{
                        name: 'Transactions',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/messages', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, data[i].count]);
                    }
                 
                    // draw chart
                    $('#messages').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Messages"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Count"
                        }
                    },
                    series: [{
                        name: 'Messages',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/transactions', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, parseFloat(data[i].fee_usd) / 100000000]);
                    }
                 
                    // draw chart
                    $('#fee_usd').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Fee (USD)"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Dollars"
                        }
                    },
                    series: [{
                        name: 'Fee (USD)',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/transactions', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, parseFloat(data[i].fee)]);
                    }
                 
                    // draw chart
                    $('#fee').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Fee"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Satoshis"
                        }
                    },
                    series: [{
                        name: 'Fee',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/transactions', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, parseFloat(data[i].size)]);
                    }
                 
                    // draw chart
                    $('#size').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "Size"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Bytes"
                        }
                    },
                    series: [{
                        name: 'Size',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
<?php $types = ["sends", "orders", "issuances", "cancels", "broadcasts", "burns", "btcpays", "dividends", "bets", "rps", "rpsresolves", "destructions"]; ?>
@foreach($types as $type)
    <script type="text/javascript">
        $(function () {
                var processed_json = new Array();   
                $.getJSON('http://xcpfox.com/api/transactions/{{ $type }}', function(data) {
                    // Populate series
                    for (i = 0; i < data.length; i++){
                        processed_json.push([data[i].year + '-' + data[i].month, data[i].count]);
                    }
                 
                    // draw chart
                    $('#{{ $type }}').highcharts({
                    chart: {
                        type: "column"
                    },
                    title: {
                        text: "{{ ucfirst($type) }}"
                    },
                    xAxis: {
                        type: 'category',
                        allowDecimals: false,
                        title: {
                            text: ""
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Count"
                        }
                    },
                    series: [{
                        name: '{{ ucfirst($type) }}',
                        data: processed_json
                    }]
                }); 
            });
        });
    </script>
@endforeach
</head>
<body>
<div id="fees_usd" style="height: 400px"></div>
<div id="fees" style="height: 400px"></div>
<div id="messages" style="height: 400px"></div>
<div id="transactions" style="height: 400px"></div>
<div id="fee_usd" style="height: 400px"></div>
<div id="fee" style="height: 400px"></div>
<div id="size" style="height: 400px"></div>
@foreach($types as $type)
    <div id="{{ $type }}" style="height: 400px"></div>
@endforeach
</body>
</html>