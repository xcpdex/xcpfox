<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('messages.index', compact('request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $message_index)
    {
        $message = \App\Message::findOrFail($message_index);

        $message_type = getTitleFromType($message->category);

        $bindings = json_encode(json_decode($message->bindings), JSON_PRETTY_PRINT);

        return view('messages.show', compact('message', 'message_type', 'bindings'));
    }
}
