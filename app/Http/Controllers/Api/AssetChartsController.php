<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetChartsController extends Controller
{
    /**
     * Related Assets
     *
     * @return \Illuminate\Http\Response
     */
    public function relatedAssets(Request $request, $asset_name)
    {
        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_related_assets_' . $asset->asset_name, 2880, function () use ($asset) {

            if($asset->asset_name === 'BTC')
            {
                $holders = $asset->currentBalances()->count();

                $results = \App\Balance::current()
                    ->where('asset', '!=', $asset->asset_name)
                    ->selectRaw('COUNT(id) as count, (COUNT(id) / ' . $holders . ' * 100) as percent, asset')
                    ->groupBy('asset')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            } 
            else
            {
                $holders = $asset->currentBalances()->count();

                $addresses = \Cache::remember('assests_show_' . $asset->asset_name . '_holders', 2880, function () use ($asset) {
                    return $asset->currentBalances()->pluck('address');
                });

                $results = \App\Balance::current()
                    ->where('asset', '!=', $asset->asset_name)
                    ->whereIn('address', $addresses)
                    ->selectRaw('COUNT(id) as count, (COUNT(id) / ' . $holders . ' * 100) as percent, asset')
                    ->groupBy('asset')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }

            return \App\Http\Resources\RelatedResource::collection($results);
        });
    }

    /**
     * Active Addresses
     *
     * @return \Illuminate\Http\Response
     */
    public function activeAddresses(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_active_addresses_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            if($asset->asset_name === 'BTC')
            {
                switch($group_by)
                {
                    case 'date':
                        $results = \App\Balance::where('asset', '!=', 'BTC')
                            ->selectRaw('DATE(confirmed_at) as date, COUNT(DISTINCT address) as count')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
                        break;
                    case 'month':
                        $results = \App\Balance::where('asset', '!=', 'BTC')
                            ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(DISTINCT address) as count')
                            ->groupBy('month', 'year')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
                        break;
                    case 'year':
                        $results = \App\Balance::where('asset', '!=', 'BTC')
                            ->selectRaw('YEAR(confirmed_at) as year, COUNT(DISTINCT address) as count')
                            ->groupBy('year')
                            ->orderBy('year')
                            ->get();
                        break;
                }
            }
            else
            {
                switch($group_by)
                {
                    case 'date':
                        $results = $asset->balances()
                            ->selectRaw('DATE(confirmed_at) as date, COUNT(DISTINCT address) as count')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
                        break;
                    case 'month':
                        $results = $asset->balances()
                            ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(DISTINCT address) as count')
                            ->groupBy('month', 'year')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
                        break;
                    case 'year':
                        $results = $asset->balances()
                            ->selectRaw('YEAR(confirmed_at) as year, COUNT(DISTINCT address) as count')
                            ->groupBy('year')
                            ->orderBy('year')
                            ->get();
                        break;
                }
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Most Active Addresses
     *
     * @return \Illuminate\Http\Response
     */
    public function mostActiveAddresses(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_most_active_addresses_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            if($asset->asset_name === 'BTC')
            {
                $results = \App\Balance::where('asset', '!=', 'BTC')
                    ->selectRaw('COUNT(id) as count, address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }
            else
            {
                $results = \App\Balance::where('asset', '=', $asset->asset_name)
                    ->selectRaw('COUNT(id) as count, address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }

            return \App\Http\Resources\ListAddressResource::collection($results);
        });
    }

    /**
     * Top Senders
     *
     * @return \Illuminate\Http\Response
     */
    public function topSenders(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_top_senders_' . $asset_name, 1440, function() use($asset, $group_by) {
            $results = $asset->sends()
                ->selectRaw('COUNT(tx_index) as count, source as address')
                ->groupBy('address')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();

            return \App\Http\Resources\ListAddressResource::collection($results);
        });
    }

    /**
     * Top Senders (Quantity)
     *
     * @return \Illuminate\Http\Response
     */
    public function topSendersQuantity(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_top_senders_quantity_' . $asset_name, 1440, function() use($asset, $group_by) {
            if($asset->divisible)
            {
                $results = $asset->sends()
                    ->selectRaw('(SUM(quantity) / 100000000) as count, source as address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }
            else
            {
                $results = $asset->sends()
                    ->selectRaw('SUM(quantity) as count, source as address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }

            return \App\Http\Resources\ListAddressResource::collection($results);
        });
    }

    /**
     * Unique Sends
     *
     * @return \Illuminate\Http\Response
     */
    public function uniqueSends(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_unique_sends_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = $asset->sends()
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(tx_index) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = $asset->sends()
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(tx_index) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = $asset->sends()
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(tx_index) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Tokens Sent
     *
     * @return \Illuminate\Http\Response
     */
    public function tokensSent(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_tokens_sent_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            if($asset->divisible)
            {
                if($asset->asset_name === 'BTC')
                {
                    switch($group_by)
                    {
                        case 'date':
                            $results = \App\Btcpay::selectRaw('DATE(confirmed_at) as date, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get();
                            break;
                        case 'month':
                            $results = \App\Btcpay::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('month', 'year')
                                ->orderBy('year')
                                ->orderBy('month')
                                ->get();
                            break;
                        case 'year':
                            $results = \App\Btcpay::selectRaw('YEAR(confirmed_at) as year, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                            break;
                    }
                }
                else
                {
                    switch($group_by)
                    {
                        case 'date':
                            $results = $asset->sends()
                                ->selectRaw('DATE(confirmed_at) as date, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get();
                            break;
                        case 'month':
                            $results = $asset->sends()
                                ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('month', 'year')
                                ->orderBy('year')
                                ->orderBy('month')
                                ->get();
                            break;
                        case 'year':
                            $results = $asset->sends()
                                ->selectRaw('YEAR(confirmed_at) as year, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                            break;
                    }
                }
            }
            else
            {
                switch($group_by)
                {
                    case 'date':
                        $results = $asset->sends()
                            ->selectRaw('DATE(confirmed_at) as date, SUM(quantity) as quantity')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
                        break;
                    case 'month':
                        $results = $asset->sends()
                            ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(quantity) as quantity')
                            ->groupBy('month', 'year')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
                        break;
                    case 'year':
                        $results = $asset->sends()
                            ->selectRaw('YEAR(confirmed_at) as year, SUM(quantity) as quantity')
                            ->groupBy('year')
                            ->orderBy('year')
                            ->get();
                        break;
                }
            }

            return \App\Http\Resources\QuantityTwoResource::collection($results);
        });
    }


    /**
     * Top Traders
     *
     * @return \Illuminate\Http\Response
     */
    public function topTraders(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_top_traders_' . $asset_name, 1440, function() use($asset, $group_by) {
            $results = $asset->credits()
                ->where('action', '=', 'order match')
                ->selectRaw('COUNT(id) as count, address')
                ->groupBy('address')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();

            return \App\Http\Resources\ListAddressResource::collection($results);
        });
    }

    /**
     * Top Traders (Quantity)
     *
     * @return \Illuminate\Http\Response
     */
    public function topTradersQuantity(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_top_traders_quantity_' . $asset_name, 1440, function() use($asset, $group_by) {
            if($asset->divisible)
            {
                $results = $asset->credits()
                    ->where('action', '=', 'order match')
                    ->selectRaw('(SUM(quantity) / 100000000) as count, address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }
            else
            {
                $results = $asset->credits()
                    ->where('action', '=', 'order match')
                    ->selectRaw('SUM(quantity) as count, address')
                    ->groupBy('address')
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->get();
            }

            return \App\Http\Resources\ListAddressResource::collection($results);
        });
    }

    /**
     * Unique Trades
     *
     * @return \Illuminate\Http\Response
     */
    public function uniqueTrades(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_unique_trades_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = $asset->credits()
                        ->where('action', '=', 'order match')
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(id) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = $asset->credits()
                        ->where('action', '=', 'order match')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(id) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = $asset->credits()
                        ->where('action', '=', 'order match')
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(id) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Tokens Traded
     *
     * @return \Illuminate\Http\Response
     */
    public function tokensTraded(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_simple_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)->firstOrFail();
            });
        }

        return \Cache::remember('api_asset_charts_tokens_traded_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            if($asset->divisible)
            {
                if($asset->asset_name === 'BTC')
                {
                    switch($group_by)
                    {
                        case 'date':
                            $results = \App\Btcpay::selectRaw('DATE(confirmed_at) as date, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get();
                            break;
                        case 'month':
                            $results = \App\Btcpay::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('month', 'year')
                                ->orderBy('year')
                                ->orderBy('month')
                                ->get();
                            break;
                        case 'year':
                            $results = \App\Btcpay::selectRaw('YEAR(confirmed_at) as year, (SUM(btc_amount) / 100000000) as quantity')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                            break;
                    }
                }
                else
                {
                    switch($group_by)
                    {
                        case 'date':
                            $results = $asset->credits()
                                ->where('action', '=', 'order match')
                                ->selectRaw('DATE(confirmed_at) as date, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get();
                            break;
                        case 'month':
                            $results = $asset->credits()
                                ->where('action', '=', 'order match')
                                ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('month', 'year')
                                ->orderBy('year')
                                ->orderBy('month')
                                ->get();
                            break;
                        case 'year':
                            $results = $asset->credits()
                                ->where('action', '=', 'order match')
                                ->selectRaw('YEAR(confirmed_at) as year, (SUM(quantity) / 100000000) as quantity')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                            break;
                    }
                }
            }
            else
            {
                switch($group_by)
                {
                    case 'date':
                        $results = $asset->credits()
                            ->where('action', '=', 'order match')
                            ->selectRaw('DATE(confirmed_at) as date, SUM(quantity) as quantity')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
                        break;
                    case 'month':
                        $results = $asset->credits()
                            ->where('action', '=', 'order match')
                            ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(quantity) as quantity')
                            ->groupBy('month', 'year')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
                        break;
                    case 'year':
                        $results = $asset->credits()
                            ->where('action', '=', 'order match')
                            ->selectRaw('YEAR(confirmed_at) as year, SUM(quantity) as quantity')
                            ->groupBy('year')
                            ->orderBy('year')
                            ->get();
                        break;
                }
            }


            return \App\Http\Resources\QuantityTwoResource::collection($results);
        });
    }
}
