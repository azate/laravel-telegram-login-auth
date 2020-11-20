<?php

namespace Azate\LaravelTelegramLoginAuth\Telegram;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\NotAllRequiredAttributesException;
use Illuminate\Support\Collection;

abstract class AbstractEntityFactory
{
    protected function createAttributesCollection(array $attributes): Collection
    {
        $attributesCollection = new Collection($attributes);

        if ($attributesCollection->count() !== count($this->getRequiredAttributes())) {
            throw new NotAllRequiredAttributesException();
        }

        return $attributesCollection;
    }

    protected function getRequiredAttributes(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'username',
            'photo_url',
            'auth_date',
            'hash',
        ];
    }
}
