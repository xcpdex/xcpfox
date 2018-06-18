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
        \App\Jobs\UpdateMempool::dispatchNow();

        return view('mempool.index', compact('request'));
    }
}
