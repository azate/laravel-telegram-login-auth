<?php

namespace Azate\LaravelTelegramLoginAuth\Validation\Rules;

use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\ResponseOutdatedException;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\Rule as RuleContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Illuminate\Support\Carbon;

class ResponseNotOutdatedRule implements RuleContract
{
    public function validate(EntityContract $entity): void
    {
        if (!Carbon::now('UTC')->lessThanOrEqualTo($entity->getAuthDate()->addHour())) {
            throw new ResponseOutdatedException();
        }
    }
}
