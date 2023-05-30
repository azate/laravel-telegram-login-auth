<?php

namespace Azate\LaravelTelegramLoginAuth\Validation\Rules;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\Rule as RuleContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\SignatureException;
use TgWebValid\TgWebValid;

class SignatureRule implements RuleContract
{
    private TgWebValid $validator;

    public function __construct(
        private string $secretKey
    )
    {
        $this->validator = new TgWebValid($this->secretKey);
    }

    public function validate(EntityContract $entity): void
    {
        if (!$this->validator->validateLoginWidget($entity->toArray())) {
            throw new SignatureException();
        }
    }
}
