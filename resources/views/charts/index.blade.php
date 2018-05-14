@extends('layouts.app')

@section('title', 'Counterparty Charts')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Counterparty Charts</h1>
    <h3 class="text-center mt-5">Price Data</h3>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.xcp-price')) }}">
                    <img class="card-img-top" src="{{ asset('/images/xcp-price-usd.png') }}" alt="XCP Price Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.xcp-price')) }}">
                            XCP Price
                        </a>
                    </h5>
                    <p class="card-text">USD price history for Counterparty's native currency XCP.</p>
                    <a href="{{ url(route('charts.xcp-price')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.xcp-market-cap')) }}">
                    <img class="card-img-top" src="{{ asset('/images/xcp-market-cap-usd.png') }}" alt="XCP Market Cap Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.xcp-market-cap')) }}">
                            XCP Market Cap
                        </a>
                    </h5>
                    <p class="card-text">USD market cap history for Counterparty's native currency XCP.</p>
                    <a href="{{ url(route('charts.xcp-market-cap')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.xcp-volume')) }}">
                    <img class="card-img-top" src="{{ asset('/images/xcp-volume-usd.png') }}" alt="XCP Volume Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.xcp-volume')) }}">
                            XCP Volume
                        </a>
                    </h5>
                    <p class="card-text">USD volume history for Counterparty's native currency XCP.</p>
                    <a href="{{ url(route('charts.xcp-volume')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center mt-5">Fee Data</h3>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.average-fee')) }}">
                    <img class="card-img-top" src="{{ asset('/images/average-counterparty-fee.png') }}" alt="Average Counterparty Fee Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.average-fee')) }}">
                            Average Fee
                        </a>
                    </h5>
                    <p class="card-text">Chart of the average transaction fee paid by a Counterparty user.</p>
                    <a href="{{ url(route('charts.average-fee')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.average-fee-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.total-fees')) }}">
                    <img class="card-img-top" src="{{ asset('/images/total-counterparty-fees.png') }}" alt="Total Counterparty Fees Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.total-fees')) }}">
                            Total Fees
                        </a>
                    </h5>
                    <p class="card-text">Chart of all transaction fees paid by Counterparty users.</p>
                    <a href="{{ url(route('charts.total-fees')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.total-fees-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.cumulative-fees')) }}">
                    <img class="card-img-top" src="{{ asset('/images/cumulative-counterparty-fees.png') }}" alt="Cumulative Counterparty Fees Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.cumulative-fees')) }}">
                            Cumulative Fees
                        </a>
                    </h5>
                    <p class="card-text">Cumulative transaction fees paid by Counterparty users over time.</p>
                    <a href="{{ url(route('charts.cumulative-fees')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.cumulative-fees-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.average-fee-rate')) }}">
                    <img class="card-img-top" src="{{ asset('/images/average-fee-rate.png') }}" alt="Average Counterparty Fee Rate Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.average-fee-rate')) }}">
                            Avg. Fee Rate
                        </a>
                    </h5>
                    <p class="card-text">Chart of the average fee rate paid by a Counterparty user.</p>
                    <a href="{{ url(route('charts.average-fee-rate')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center mt-5">Size Data</h3>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.average-size')) }}">
                    <img class="card-img-top" src="{{ asset('/images/average-transaction-size.png') }}" alt="Average Transacation Size Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.average-size')) }}">
                            Average Size
                        </a>
                    </h5>
                    <p class="card-text">Chart of the average size, in bytes, of a Counterparty transaction.</p>
                    <a href="{{ url(route('charts.average-size')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.total-size')) }}">
                    <img class="card-img-top" src="{{ asset('/images/total-transaction-data.png') }}" alt="Total Transaction Data Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.total-size')) }}">
                            Total Size
                        </a>
                    </h5>
                    <p class="card-text">Chart of the total amount of data used by Counterparty transactions.</p>
                    <a href="{{ url(route('charts.total-size')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.cumulative-size')) }}">
                    <img class="card-img-top" src="{{ asset('/images/cumulative-transaction-data.png') }}" alt="Cumulative Transaction Data Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.cumulative-size')) }}">
                            Cumulative Size
                        </a>
                    </h5>
                    <p class="card-text">Cumulative transaction data used by Counterparty users over time.</p>
                    <a href="{{ url(route('charts.cumulative-size')) }}" class="btn btn-primary">View Chart</a>
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center mt-5">Burn Data</h3>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.average-burn')) }}">
                    <img class="card-img-top" src="{{ asset('/images/average-bitcoin-burn.png') }}" alt="Average Bitcoin Burn Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.average-burn')) }}">
                            Average Burn
                        </a>
                    </h5>
                    <p class="card-text">Average bitcoin burn during the initial burn offering (January 2014.)</p>
                    <a href="{{ url(route('charts.average-burn')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.average-burn-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.total-burn')) }}">
                    <img class="card-img-top" src="{{ asset('/images/total-bitcoin-burned.png') }}" alt="Total Bitcoin Burn Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.total-burn')) }}">
                            Total Burn
                        </a>
                    </h5>
                    <p class="card-text">Total bitcoin burned during the initial burn offering (January 2014.)</p>
                    <a href="{{ url(route('charts.total-burn')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.total-burn-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card text-center">
                <a href="{{ url(route('charts.cumulative-burn')) }}">
                    <img class="card-img-top" src="{{ asset('/images/cumulative-bitcoin-burned.png') }}" alt="Cumulative Bitcoin Burn Chart" />
                </a>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">
                        <a href="{{ url(route('charts.cumulative-burn')) }}">
                            Cumulative Burn
                        </a>
                    </h5>
                    <p class="card-text">Cumulative bitcoin burned during the initial burn offering (January 2014.)</p>
                    <a href="{{ url(route('charts.cumulative-burn')) }}" class="btn btn-primary">BTC</a>
                    <a href="{{ url(route('charts.cumulative-burn-usd')) }}" class="btn btn-primary">USD</a>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center mt-5 lead">Interested in learning more about Counterparty? Join our <a href="https://t.me/xcpdex" target="_blank">Telegram Chat</a>!</p>
</div>
@endsection