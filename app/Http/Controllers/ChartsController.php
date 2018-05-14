<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('charts.index');      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showXcpPrice(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.xcp-price', compact('chart'));    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showXcpVolume(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.xcp-volume', compact('chart'));    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showXcpMarketCap(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.xcp-market-cap', compact('chart'));    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTxsByType(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.txs-by-type', compact('chart', 'group_by'));    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageBurn(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.average-burn', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageBurnUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.average-burn-usd', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalBurn(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.total-burn', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalBurnUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.total-burn-usd', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCumulativeBurn(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.cumulative-burn', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCumulativeBurnUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
        ]);

        $chart = $request->input('chart', 'area');

        return view('charts.cumulative-burn-usd', compact('chart'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalFees(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.total-fees', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalFeesUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.total-fees-usd', compact('chart', 'group_by'));      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCumulativeFees(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.cumulative-fees', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCumulativeFeesUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.cumulative-fees-usd', compact('chart', 'group_by'));      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFee(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.average-fee', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFeeUsd(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.average-fee-usd', compact('chart', 'group_by'));      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFeeRate(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.average-fee-rate', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalSize(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.total-size', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCumulativeSize(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.cumulative-size', compact('chart', 'group_by'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageSize(Request $request)
    {
        $request->validate([
            'chart' => 'sometimes|in:area,line,column',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart = $request->input('chart', 'area');
        $group_by = $request->input('group_by', 'date');

        return view('charts.average-size', compact('chart', 'group_by'));        
    }
}
