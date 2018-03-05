<?php

namespace Azate\LaravelTelegramLoginAuth;

use Illuminate\Support\ServiceProvider;

class TelegramLoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = __DIR__ . '/../config/telegram_login_auth.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $path => config_path('telegram_login_auth.php'),
            ]);
        }

        $this->mergeConfigFrom($path, 'telegram_login_auth');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('telegram_login.auth', function () {
            return new TelegramLoginAuth($this->app['request']);
        });
    }
}
