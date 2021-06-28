# Telegram Login for Laravel
[![License](https://poser.pugx.org/azate/laravel-telegram-login-auth/license)](https://packagist.org/packages/azate/laravel-telegram-login-auth)
[![Latest Stable Version](https://poser.pugx.org/azate/laravel-telegram-login-auth/v/stable)](https://packagist.org/packages/azate/laravel-telegram-login-auth)
[![Total Downloads](https://poser.pugx.org/azate/laravel-telegram-login-auth/downloads)](https://packagist.org/packages/azate/laravel-telegram-login-auth)

This package is a Laravel service provider which provides support for Laravel Login and is very easy to integrate with any project that requires Telegram authentication.

## Installation
Require this package with composer.
```shell
composer require azate/laravel-telegram-login-auth
```
Laravel >=5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Azate\LaravelTelegramLoginAuth\Providers\LaravelServiceProvider" --tag=config
```
## Usage example

Setup information [Telegram Login Widget](https://core.telegram.org/widgets/login)

### Not detailed errors
```php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

// ...
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;

// ...
public function handleTelegramCallback(TelegramLoginAuth $telegramLoginAuth, Request $request)
{
    if ($user = $telegramLoginAuth->validate($request)) {
        // ...
    }

    // ...
}
```

### With detailed errors
```php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

// ...
use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\NotAllRequiredAttributesException;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\ResponseOutdatedException;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\SignatureException;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;

// ...
public function handleTelegramCallback(TelegramLoginAuth $telegramLoginAuth, Request $request)
{
    try {
        $user = $telegramLoginAuth->validateWithError($request);
    } catch(NotAllRequiredAttributesException $e) {
        // ...
    } catch(SignatureException $e) {
        // ...
    } catch(ResponseOutdatedException $e) {
        // ...
    } catch(Exception $e) {
        // ...
    }

    // ...
}
```
