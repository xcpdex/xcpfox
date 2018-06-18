<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Message Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('messages.index', compact('request'));
    }

    /**
     * Show a Message
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $message)
    {
        $message = \App\Message::with('transaction')->findOrFail($message);

        $message_type = getTitleFromType($message->category);

        $bindings = json_encode(json_decode($message->bindings), JSON_PRETTY_PRINT);

        return view('messages.show', compact('message', 'message_type', 'bindings'));
    }
}
