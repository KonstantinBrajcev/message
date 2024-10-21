<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/', function () {return view('welcome');});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Отправка тестового сообщения
Route::get('test-telegram', function () {
    Telegram::sendMessage([
        'chat_id' => 798593067,
        'parse_mode' => 'html',
        'text' => 'Произошло тестовое событие'
    ]);
    return response()->json(['status' => 'success']);
});

// npm run dev
// php artisan serve
