<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MempoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            \App\Jobs\UpdateMempool::dispatchNow();
        }
        catch(\Exception $e)
        {
        }

        return view('mempool.index', compact('request'));
    }
}
