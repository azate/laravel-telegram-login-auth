<?php

declare(strict_types=1);

namespace Azate\LaravelTelegramLoginAuth;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class TelegramLoginAuth
 *
 * @package Azate\TelegramLoginAuth
 */
final class TelegramLoginAuth
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new TelegramLoginAuth instance
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Returns only the requested data
     *
     * @return array
     */
    private function getRequestData(): array
    {
        return $this->request->only([
            'id',
            'first_name',
            'last_name',
            'username',
            'photo_url',
            'auth_date',
            'hash',
        ]);
    }

    /**
     * Checks
     *
     * @return bool
     */
    public function validate(): bool
    {
        $data = $this->getRequestData();

        $checkSum = $data['hash'] ?? '';

        $dataCheckString = collect($data)
            ->except('hash')
            ->map(function ($value, $key) {
                return $key . '=' . $value;
            })
            ->sort()
            ->values()
            ->implode("\n");

        $secretKey = hash('sha256', config('telegram_login_auth.token'), true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        if (strcmp($hash, $checkSum) !== 0) {
            return false;
        }

        $authDate = Carbon::createFromTimestampUTC($data['auth_date']);

        if (Carbon::now()->greaterThanOrEqualTo($authDate->addHour())) {
            return false;
        }

        return true;
    }

    /**
     * Returns the user data
     *
     * @return array
     */
    public function user(): array
    {
        $data = $this->getRequestData();

        return [
            'id' => $data['id'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'username' => $data['username'] ?? null,
            'avatar' => $data['photo_url'] ?? null,
        ];
    }
}
