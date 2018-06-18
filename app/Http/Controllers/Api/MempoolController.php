<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MempoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        $transactions = \App\Mempool::whereDoesntHave('transaction')
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10));

        return \App\Http\Resources\MempoolResource::collection($transactions);
    }
}
