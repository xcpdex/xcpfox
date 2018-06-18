<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapsController extends Controller
{
    /**
     * Sitemap Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $per_page=50000)
    {
        $address_pages = ceil(\App\Address::count() / $per_page);

        $sitemaps[] = [
            'type' => 'addresses',
            'pages' => $address_pages,
        ];

        $asset_pages = ceil(\App\Asset::count() / $per_page);

        $sitemaps[] = [
            'type' => 'assets',
            'pages' => $asset_pages,
        ];

        $block_pages = ceil(\App\Block::count() / $per_page);

        $sitemaps[] = [
            'type' => 'blocks',
            'pages' => $block_pages,
        ];

        $transaction_pages = ceil(\App\Transaction::count() / $per_page);

        $sitemaps[] = [
            'type' => 'transactions',
            'pages' => $transaction_pages,
        ];

        return view('sitemaps.index', compact('sitemaps', 'per_page'));
    }

    /**
     * Show a Sitemap
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $type, $page, $per_page=50000)
    {
        $results = \Cache::remember('sitemap_' . $type . '_' .  $page, 1440, function() use($type, $page, $per_page) {
            $skip = ($page - 1) * $per_page;
            $model = getModelNameFromType($type);

            return $model::skip($skip)->take($per_page)->get();
        });

        return view('sitemaps.show', compact('type', 'results'));
    }

    /**
     * Routes Sitemap
     *
     * @return \Illuminate\Http\Response
     */
    public function routes(Request $request)
    {
        $routes = [
            'home',
            'about',
            'contact',
            'disclaimer',
            'docs',
            'node',
            'protocol',
            'faq',
            'privacy',
            'terms',
            'assets.index',
            'blocks.index',
            'charts.index',
            'charts.addresses',
            'charts.activeAddresses',
            'charts.hodlAddresses',
            'charts.assets',
            'charts.activeAssets',
            'charts.blockShare',
            'charts.btcBurned',
            'charts.fees',
            'charts.averageFee',
            'charts.feeRates',
            'charts.gasFees',
            'charts.messages',
            'charts.orders',
            'charts.registrationFee',
            'charts.sends',
            'charts.mostSends',
            'charts.transactions',
            'charts.transactionSize',
            'charts.xcpSupply',
            'charts.areaRange.burnRate',
            'charts.areaRange.feeRate',
            'charts.areaRange.orderExpiration',
            'charts.areaRange.transactionSize',
            'charts.pie.addresses',
            'charts.pie.assets',
            'charts.pie.blocks',
            'charts.pie.messages',
            'charts.pie.transactions',
            'leaderboard.index',
            'messages.index',
            'search.index',
            'transactions.index',
            'mempool.index',
        ];

        return view('sitemaps.routes', compact('routes'));
    }
}