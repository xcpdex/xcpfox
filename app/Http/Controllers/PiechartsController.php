<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiechartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddresses(Request $request)
    {
        return view('charts.pie.addresses');        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAssets(Request $request)
    {
        return view('charts.pie.assets');        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlocks(Request $request)
    {
        return view('charts.pie.blocks');        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessages(Request $request)
    {
        return view('charts.pie.messages');        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactions(Request $request)
    {
        return view('charts.pie.transactions');        
    }
}
