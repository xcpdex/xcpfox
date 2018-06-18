<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $market_data = $this->getMarketData();
        return view('home', compact('market_data'));
    }

    private function getMarketData()
    {
        return \Cache::remember('api_market_data', 5, function () {
            $data = json_decode(file_get_contents('http://coincap.io/history/XCP', true));
            return [
                'price' => '$' . number_format(last($data->price)[1], 2),
                'volume' => '$' . number_format(last($data->volume)[1]),
                'market_cap' => '$' . number_format(last($data->market_cap)[1]),
            ];
        });
    }
}
