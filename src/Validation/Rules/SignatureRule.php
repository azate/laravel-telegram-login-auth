<?php

namespace Azate\LaravelTelegramLoginAuth\Validation\Rules;

use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\Rule as RuleContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\SignatureException;
use Illuminate\Support\Collection;

class SignatureRule implements RuleContract
{
    /**
     * @var string
     */
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function validate(EntityContract $entity): void
    {
        $knownHash = $entity->getHash();
        $userHash = $this->createHash($this->createDataCheckString($entity), $this->createSecretKeyHash());

        if ($this->isNotHashMatched($knownHash, $userHash)) {
            throw new SignatureException();
        }
    }

    private function createHash(string $data, string $secretKey): string
    {
        return hash_hmac('sha256', $data, $secretKey);
    }

    private function createDataCheckString(EntityContract $entity): string
    {
        return (new Collection($entity->toArray()))
            ->except('hash')
            ->filter()
            ->map(function ($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->sort()
            ->implode("\n");
    }

    private function createSecretKeyHash(): string
    {
        return hash('sha256', $this->secretKey, true);
    }

    private function isNotHashMatched(string $knownHash, string $userHash): bool
    {
        return !hash_equals($knownHash, $userHash);
    }
}
