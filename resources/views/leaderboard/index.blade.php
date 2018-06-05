@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
<div class="container mt-1">
    <a name="top"></a>
    <h1>Leaderboard <small class="lead">Top 10</small></h1>
    <div class="card bg-light my-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <h4>Addresses</h4>
                    <ul>
                        <li><a href="#highest-xcp-balance">Highest XCP Balance</a></li>
                        <li><a href="#most-active-address">Most Active Address</a></li>
                        <li><a href="#most-balances-held">Most Balances Held</a></li>
                        <li><a href="#most-assets-issued">Most Assets Issued</a></li>
                        <li><a href="#most-sends-created">Most Sends Created</a></li>
                        <li><a href="#most-orders-created">Most Orders Created</a></li>
                        <li><a href="#most-broadcasts-made">Most Broadcasts Made</a></li>
                        <li><a href="#most-dividends-paid">Most Dividends Paid</a></li>
                        <li><a href="#most-bets-placed">Most Bets Placed</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h4>Assets</h4>
                    <ul>
                        <li><a href="#most-held-asset">Most Held Asset</a></li>
                        <li><a href="#most-active-asset">Most Active Asset</a></li>
                        <li><a href="#most-sent-asset">Most Sent Asset</a></li>
                        <li><a href="#most-traded-asset">Most Traded Asset</a></li>
                        <li><a href="#most-dividends-paid-asset">Most Dividends Paid</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h4>Fees</h4>
                    <ul>
                        <li><a href="#most-btc-fees">Most BTC Fees</a></li>
                        <li><a href="#most-xcp-fees">Most XCP Fees</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center text-muted">The leaderboards on this page are updated weekly.</p>
    <a name="highest-xcp-balance"></a>
    <h2 class="mt-4">Highest XCP Balance</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_xcp as $balance)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $balance->address])) }}">{{ $balance->address }}</a></td>
                            <td class="text-right">{{ number_format($balance->quantity_normalized, 8) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-active-address"></a>
    <h2 class="mt-4">Most Active Address</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Credits + Debits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_active as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->balances_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-balances-held"></a>
    <h2 class="mt-4">Most Balances Held</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Unique Balances</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_balances as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->current_balances_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-assets-issued"></a>
    <h2 class="mt-4">Most Assets Issued</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Assets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_assets as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->issued_assets_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-sends-created"></a>
    <h2 class="mt-4">Most Sends Created</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Sends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_sends as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->sends_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-orders-created"></a>
    <h2 class="mt-4">Most Orders Created</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Orders</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_orders as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->orders_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-broadcasts-made"></a>
    <h2 class="mt-4">Most Broadcasts Made</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Broadcasts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_broadcasts as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->broadcasts_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-dividends-paid"></a>
    <h2 class="mt-4">Most Dividends Paid</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Dividends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_dividends as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->dividends_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-bets-placed"></a>
    <h2 class="mt-4">Most Bets Placed</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>Bets</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_bets as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format($address->bets_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-held-asset"></a>
    <h2 class="mt-4">Most Held Asset</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Asset</th>
                            <th>Holders</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_asset_holders as $asset)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></td>
                            <td class="text-right">{{ number_format($asset->current_balances_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-active-asset"></a>
    <h2 class="mt-4">Most Active Asset</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Asset</th>
                            <th>Credits + Debits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_active_assets as $asset)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></td>
                            <td class="text-right">{{ number_format($asset->balances_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-sent-asset"></a>
    <h2 class="mt-4">Most Sent Asset</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Asset</th>
                            <th>Sends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_asset_sends as $asset)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></td>
                            <td class="text-right">{{ number_format($asset->sends_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-traded-asset"></a>
    <h2 class="mt-4">Most Traded Asset</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Asset</th>
                            <th>Trades</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_asset_trades as $credit)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('assets.show', ['asset' => $credit->asset])) }}">{{ $credit->asset }}</a></td>
                            <td class="text-right">{{ number_format($credit->count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-dividends-paid-asset"></a>
    <h2 class="mt-4">Most Dividends Paid</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Asset</th>
                            <th>Dividends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_asset_dividends as $asset)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('assets.show', ['asset' => $asset->display_name])) }}">{{ $asset->display_name }}</a></td>
                            <td class="text-right">{{ number_format($asset->dividends_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-btc-fees"></a>
    <h2 class="mt-4">Most BTC Fees</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>BTC</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_btc_paid as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format(fromSatoshi($address->fees), 8) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center"><a href="#top">Back to Top ^</a></p>
    <a name="most-xcp-fees"></a>
    <h2 class="mt-4">Most XCP Fees</h2>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Rank</th>
                            <th>Address</th>
                            <th>XCP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($most_xcp_paid as $address)
                        <tr>
                            <th>{{ $loop->iteration }}.</th>
                            <td><a href="{{ url(route('addresses.show', ['address' => $address->address])) }}">{{ $address->address }}</a></td>
                            <td class="text-right">{{ number_format(fromSatoshi($address->fees), 8) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.cta')
</div>
@endsection