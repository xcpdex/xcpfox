<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiechartsController extends Controller
{
    /**
     * Show Address Types
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddresses(Request $request)
    {
        return view('charts.pie.addresses');        
    }

    /**
     * Show Asset Types
     *
     * @return \Illuminate\Http\Response
     */
    public function showAssets(Request $request)
    {
        return view('charts.pie.assets');        
    }

    /**
     * Show Block Presence
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlocks(Request $request)
    {
        return view('charts.pie.blocks');        
    }

    /**
     * Show Message Categories
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessages(Request $request)
    {
        return view('charts.pie.messages');        
    }

    /**
     * Show Transaction Types
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactions(Request $request)
    {
        return view('charts.pie.transactions');        
    }
}
