# Telegram Login for Laravel 5
[![License](https://poser.pugx.org/azate/laravel-telegram-login-auth/license)](https://packagist.org/packages/azate/laravel-telegram-login-auth)
[![Latest Stable Version](https://poser.pugx.org/azate/laravel-telegram-login-auth/v/stable)](https://packagist.org/packages/azate/laravel-telegram-login-auth)
[![Total Downloads](https://poser.pugx.org/azate/laravel-telegram-login-auth/downloads)](https://packagist.org/packages/azate/laravel-telegram-login-auth)

This package is a Laravel 5 service provider which provides support for Laravel Login and is very easy to integrate with any project that requires Telegram authentication.

## Installation
Require this package with composer.
```shell
composer require azate/laravel-telegram-login-auth
```
Laravel >=5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Azate\LaravelTelegramLoginAuth\TelegramLoginServiceProvider"
```
## Usage example

Setup information [Telegram Login Widget](https://core.telegram.org/widgets/login)

In `routes/web.php`:
```php
Route::get('auth/telegram/callback', 'AuthController@handleTelegramCallback')->name('auth.telegram.handle');
```

In `AuthController`:
```php
namespace App\Http\Controllers;

use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;

class AuthController extends Controller
{
    /**
     * @var TelegramLoginAuth
     */
    protected $telegram;

    /**
     * AuthController constructor.
     *
     * @param TelegramLoginAuth $telegram
     */
    public function __construct(TelegramLoginAuth $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Get user info and log in (hypothetically)
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function handleTelegramCallback()
    {
        if ($this->telegram->validate()) {
            $user = $this->telegram->user();

            //
        }

        return redirect('/');
    }
}
```
