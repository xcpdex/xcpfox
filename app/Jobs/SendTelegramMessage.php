<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach([env('XCP_FOX_CHAT_ROOM'), env('XCP_DEX_CHAT_ROOM')] as $chat_id)
        {
            \Telegram::sendMessage([
                'chat_id' => $chat_id, 
                'text' => $this->text,
                'parse_mode' => 'Markdown',
                'disable_notification' => true,
                'disable_web_page_preview' => true,
            ]);
        }
    }
}