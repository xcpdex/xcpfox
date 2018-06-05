<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('addresses.index', compact('request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $address)
    {
        $address = \App\Address::withCount('issuedAssets', 'ownedAssets')->with('currentBalances')->findOrFail($address);

        return view('addresses.show', compact('address'));
    }
}
