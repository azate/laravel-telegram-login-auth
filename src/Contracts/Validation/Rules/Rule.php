<?php

namespace Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity;

interface Rule
{
    public function validate(Entity $entity): void;
}
