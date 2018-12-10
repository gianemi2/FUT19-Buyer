<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Backpack\Settings\app\Models\Setting;

class TelegramBotController extends Controller
{
    public function sendMessage($text, $disable_alarm = false)
    {
        $telegram_ids = Setting::get('telegram_id');
        $telegram_ids = explode(',', $telegram_ids);
        if($disable_alarm){
            if(isset($telegram_ids[1])){
                $channel_id = str_replace(' ', '', $telegram_ids[1]);
            } else {
                $channel_id = str_replace(' ', '', $telegram_ids[0]);
            }
        } else {
            $channel_id = str_replace(' ', '', $telegram_ids[0]);
        }
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', $channel_id),
            'parse_mode'    =>  'Markdown',
            'text' => $text
        ]);
    }
}
