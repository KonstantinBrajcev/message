<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\TelegramController;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Создание пользователя
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Отправка сообщения в Telegram
            $telegramController = new TelegramController();
            $telegramController->sendMessage($user);

            //Отправка сообщения на почту
            Mail::raw("Новый пользователь зарегистрирован: {$user->name}, Email: {$user->email}", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Регистрация нового пользователя!');
                        // ->cc('kastettb@gmail.com');
            });

        // Перенаправление на страницу
        return redirect()->route('home')->with('success', 'Регистрация прошла успешно!');
    }
}
