<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($redirect = $this->getExactMatch($request))
        {
            return redirect($redirect);
        }
        else
        {
            return view('search.index', compact('request'));
        }
    }

    private function getExactMatch($request)
    {
        if(! $request->has('q')) return false;
        if(preg_match('/[^A-Za-z0-9.-_@!]/', $request->q)) return false;

        if(strlen($request->q) === 64)
        {
            try
            {
                $transaction = \App\Transaction::whereTxHash($request->q)->firstOrFail();

                return $transaction->url;
            }
            catch(\Exception $e)
            {
                return false;
            }
        }
        elseif(strlen($request->q) > 21 && strpos($request->q, '.') === false)
        {
            try
            {
                $address = \App\Address::findOrFail($request->q);

                return $address->url;
            }
            catch(\Exception $e)
            {
                return false;
            }
        }
        else
        {
            try
            {
                $asset = \App\Asset::where('asset_name', '=', $request->q)
                    ->orWhere('asset_longname', '=', $request->q)
                    ->firstOrFail();

                return $asset->url;
            }
            catch(\Exception $e)
            {
                return false;
            }
        }
    }
}
