<?php

namespace Azate\LaravelTelegramLoginAuth\Validation;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\Rules\Rule as RuleContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\ValidatorChain as ValidatorChainContract;

final class ValidatorChain implements ValidatorChainContract
{
    /**
     * @var RuleContract[]
     */
    private $rules = [];

    public function addRule(RuleContract $rule): void
    {
        $this->rules[] = $rule;
    }

    public function validate(EntityContract $entity): void
    {
        foreach ($this->rules as $rule) {
            $rule->validate($entity);
        }
    }
}
