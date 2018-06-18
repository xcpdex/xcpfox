<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartsController extends Controller
{
    /**
     * Chart Index
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
    public function showFeeRates(Request $request)
    {
        // Not Standard
        $current = \App\Transaction::whereNotNull('processed_at')
            ->where('confirmed_at', '>', \Carbon\Carbon::now()->subDays(1))
            ->selectRaw('AVG(fee / size) as average, MIN(fee / size) as minimum, MAX(fee / size) as maximum')
            ->first();

        $subset = \App\Transaction::whereNotNull('processed_at')
            ->where('confirmed_at', '>', \Carbon\Carbon::now()->subDays(1))
            ->whereRaw('(fee / size) > ' . $current->minimum * 1.1 . ' and (fee / size) < ' . $current->average * 0.9 . '')
            ->selectRaw('AVG(fee / size) as average, MIN(fee / size) as minimum, MAX(fee / size) as maximum')
            ->first();

        return view("charts.fee-rates", compact('current', 'subset'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddresses(Request $request)
    {
        return $this->getControllerTemplate($request, 'addresses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActiveAddresses(Request $request)
    {
        return $this->getControllerTemplate($request, 'active-addresses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHodlAddresses(Request $request)
    {
        return $this->getControllerTemplate($request, 'hodl-addresses');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAssets(Request $request)
    {
        return $this->getControllerTemplate($request, 'assets');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActiveAssets(Request $request)
    {
        return $this->getControllerTemplate($request, 'active-assets');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlockShare(Request $request)
    {
        return $this->getControllerTemplate($request, 'block-share');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBtcBurned(Request $request)
    {
        return $this->getControllerTemplate($request, 'btc-burned');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFees(Request $request)
    {
        return $this->getControllerTemplate($request, 'fees');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFee(Request $request)
    {
        return $this->getControllerTemplate($request, 'average-fee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGasFees(Request $request)
    {
        $override = $request->input('currency', 'XCP');

        return $this->getControllerTemplate($request, 'gas-fees', $override);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessages(Request $request)
    {
        return $this->getControllerTemplate($request, 'messages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrders(Request $request)
    {
        return $this->getControllerTemplate($request, 'orders');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFee(Request $request)
    {
        $override = $request->input('currency', 'XCP');

        return $this->getControllerTemplate($request, 'registration-fee', $override);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSends(Request $request)
    {
        return $this->getControllerTemplate($request, 'sends');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMostSends(Request $request)
    {
        return $this->getControllerTemplate($request, 'most-sends');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactions(Request $request)
    {
        return $this->getControllerTemplate($request, 'transactions');
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
    public function showXcpSupply(Request $request)
    {
        return $this->getControllerTemplate($request, 'xcp-supply');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getControllerTemplate(Request $request, $view, $override=null)
    {
        $request->validate([
            'chart_type' => 'sometimes|in:area,line,column',
            'currency' => 'sometimes|in:BTC,USD,XCP',
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $chart_type = $request->input('chart_type', 'line');
        $currency = $override ? $override : $request->input('currency', 'BTC');
        $group_by = $request->input('group_by', 'date');

        return view("charts.{$view}", compact('chart_type', 'currency', 'group_by'));
    }
}
