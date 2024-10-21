<?php
namespace App\Http\Controllers;

class TelegramController extends Controller
{
    public function sendMessage($user)
    {
        $telegram = app('telegram');
        $chatId = 798593067;
        if (empty($chatId)) {throw new \Exception('chat_id пустой!');}
        $response = $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Новый пользователь зарегистрирован: {$user->name}, Email: {$user->email}",
        ]);
        return $response;
    }
}
