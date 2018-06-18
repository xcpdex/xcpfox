<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreaRangeChartsController extends Controller
{
    /**
     * Show Average Burn Rate
     *
     * @return \Illuminate\Http\Response
     */
    public function showBurnRate(Request $request)
    {
        return $this->getControllerTemplate($request, 'burn-rate');
    }

    /**
     * Show Average Fee Rate
     *
     * @return \Illuminate\Http\Response
     */
    public function showFeeRate(Request $request)
    {
        return $this->getControllerTemplate($request, 'fee-rate');
    }

    /**
     * Show Average Order Expiration
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderExpiration(Request $request)
    {
        return $this->getControllerTemplate($request, 'order-expiration');
    }

    /**
     * Show Average Transaction Size
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactionSize(Request $request)
    {
        return $this->getControllerTemplate($request, 'transaction-size');
    }

    /**
     * Controller Template (DRY)
     *
     * @return \Illuminate\Http\Response
     */
    private function getControllerTemplate(Request $request, $view)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'month');

        return view('charts.area-range.' . $view, compact('group_by'));
    }
}