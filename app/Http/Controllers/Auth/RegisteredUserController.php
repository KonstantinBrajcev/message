<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Отправка письма
        // Mail::to($user->email)->send(new Welcome($user));

        // Уведомление в Telegram
        Telegram::sendMessage([
            'chat_id' => 798593067,
            'text' => "Новый пользователь: {$user->name} зарегистрировался."
        ]);

        // Вход в систему (если требуется)
        // Auth::login($user);

        // Перенаправление или возврат ответа
        return redirect()->route('home')->with('success', 'Регистрация прошла успешно!');
    }
}
