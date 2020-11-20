<?php

namespace Azate\LaravelTelegramLoginAuth\Contracts\Validation;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\Rule as RuleContract;

interface ValidatorChain
{
    public function addRule(RuleContract $rule): void;

    public function validate(Entity $entity): void;
}
