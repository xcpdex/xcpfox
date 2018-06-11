<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreaRangeChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFeeRate(Request $request)
    {
        return $this->getControllerTemplate($request, 'fee-rate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderExpiration(Request $request)
    {
        return $this->getControllerTemplate($request, 'order-expiration');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactionSize(Request $request)
    {
        return $this->getControllerTemplate($request, 'transaction-size');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getControllerTemplate(Request $request, $view)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'month');

        return view("charts.area-range.{$view}", compact('group_by'));
    }
}