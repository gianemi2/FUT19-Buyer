<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function sendMessage($text, $disable_alarm = false)
    {
        if($disable_alarm){
            $channel_id = '-1001371580143';
        } else {
            $channel_id = '-1001226241583';
        }
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', $channel_id),
            'parse_mode'    =>  'Markdown',
            'text' => $text
        ]);
    }
}
