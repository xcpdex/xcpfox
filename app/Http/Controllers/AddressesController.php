<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Show Address
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $address)
    {
        $address = \App\Address::whereRaw("BINARY `address`= ?", [$address])->firstOrFail();

        return view('addresses.show', compact('address'));
    }
}
