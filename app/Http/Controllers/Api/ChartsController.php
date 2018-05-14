<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTxsByType(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('txs_by_type_' . $group_by, 1440, function() use($group_by) {
            $txs = \App\Transaction::select('type')->groupBy('type')->get();

            $stacked_results = [];

            foreach($txs as $tx)
            {
                switch($group_by)
                {
                    case 'date':
                        $results = \App\Transaction::whereType($tx->type)->selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')->groupBy('date')->orderBy('date')->get();
                        break;
                    case 'month':
                        $results = \App\Transaction::whereType($tx->type)->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                        break;
                    case 'year':
                        $results = \App\Transaction::whereType($tx->type)->selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')->groupBy('year')->orderBy('year')->get();
                        break;
                }

                $stacked_results[] = [
                    $tx->type => \App\Http\Resources\CountResource::collection($results)
                ];
            }

            return $stacked_results;
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageBurn(Request $request)
    {
        return \Cache::remember('average_burn', 360, function() {
            $results = \App\Transaction::whereType('burns')->selectRaw('DATE(confirmed_at) as date, AVG(quantity) as quantity')->groupBy('date')->orderBy('date')->get();
   
            return \App\Http\Resources\BurnResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageBurnUsd(Request $request)
    {
        return \Cache::remember('average_burn_usd', 360, function() {
            $results = \App\Transaction::whereType('burns')->selectRaw('DATE(confirmed_at) as date, AVG(quantity_usd) as quantity')->groupBy('date')->orderBy('date')->get();
   
            return \App\Http\Resources\BurnResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalBurn(Request $request)
    {
        return \Cache::remember('total_burn', 360, function() {
            $results = \App\Transaction::whereType('burns')->selectRaw('DATE(confirmed_at) as date, SUM(quantity) as quantity')->groupBy('date')->orderBy('date')->get();
   
            return \App\Http\Resources\BurnResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalBurnUsd(Request $request)
    {
        return \Cache::remember('total_burn_usd', 360, function() {
            $results = \App\Transaction::whereType('burns')->selectRaw('DATE(confirmed_at) as date, SUM(quantity_usd) as quantity')->groupBy('date')->orderBy('date')->get();
   
            return \App\Http\Resources\BurnResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalFees(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('total_fees_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, SUM(fee) as fees')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(fee) as fees')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, SUM(fee) as fees')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalFeesUsd(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('total_fees_usd_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, SUM(fee_usd) as fees')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(fee_usd) as fees')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, SUM(fee_usd) as fees')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFee(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('average_fee_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, AVG(fee) as fees')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(fee) as fees')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, AVG(fee) as fees')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFeeUsd(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('average_fee_usd_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, AVG(fee_usd) as fees')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(fee_usd) as fees')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, AVG(fee_usd) as fees')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFeeRate(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('average_fee_rate_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, SUM(fee) as fees, SUM(size) as size')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(fee) as fees, SUM(size) as size')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, SUM(fee) as fees, SUM(size) as size')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\FeeRateResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTotalSize(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('total_size_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, SUM(size) as size')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(size) as size')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, SUM(size) as size')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\SizeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageSize(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('average_size_' . $group_by, 360, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, AVG(size) as size')->groupBy('date')->orderBy('date')->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(size) as size')->groupBy('month')->groupBy('year')->orderBy('year')->orderBy('month')->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, AVG(size) as size')->groupBy('year')->orderBy('year')->get();
                    break;
            }
            return \App\Http\Resources\SizeResource::collection($results);
        });
    }
}
