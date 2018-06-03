<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
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

        return \Cache::tags(['block_flush'])->rememberForever('api_messages_index_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request) {
            $messages = \App\Message::with('transaction')
                ->whereNotNull('confirmed_at')
                ->orderBy('message_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\MessageResource::collection($messages);
        });

    }
}
