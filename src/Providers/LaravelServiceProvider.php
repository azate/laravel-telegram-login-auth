<?php

namespace Azate\LaravelTelegramLoginAuth\Providers;

use Azate\LaravelTelegramLoginAuth\Contracts\Validation\ValidatorChain as ValidatorChainContract;
use Azate\LaravelTelegramLoginAuth\Validation\ValidatorChain;
use Illuminate\Support\ServiceProvider;

final class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getPackageConfigPath() => $this->app->configPath('telegram_login_auth.php'),
            ], 'config');
        }
    }

    private function getPackageConfigPath(): string
    {
        return dirname(__DIR__, 2) . '/config/telegram_login_auth.php';
    }

    public function register(): void
    {
        $this->mergeConfigFrom($this->getPackageConfigPath(), 'telegram_login_auth');

        $this->app->bind(ValidatorChainContract::class, ValidatorChain::class);
    }
}
