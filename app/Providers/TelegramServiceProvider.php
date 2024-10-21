<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Telegram\Bot\Api;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('telegram', function ($app) {
            return new Api('TELEGRAM_BOT_TOKEN'); // Передаем токен бота
        });
    }

    public function boot(): void
    {
        //
    }
}
