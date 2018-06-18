<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    /**
     * Message Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        $key = getKeyFromRequest('api_messages_index', $request);

        return \Cache::tags(['block_flush'])->rememberForever($key, function () use ($request) {
            $messages = \App\Message::whereNotNull('confirmed_at')
                ->with('transaction')
                ->orderBy('message_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\MessageResource::collection($messages);
        });
    }
}