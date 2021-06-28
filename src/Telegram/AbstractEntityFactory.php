<?php

namespace Azate\LaravelTelegramLoginAuth\Telegram;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\NotAllRequiredAttributesException;
use Illuminate\Support\Collection;

abstract class AbstractEntityFactory
{
    protected function createAttributesCollection(array $attributes): Collection
    {
        $attributesCollection = new Collection($attributes);

        $this->validationRequiredAttributes($attributesCollection);

        return $attributesCollection;
    }

    private function validationRequiredAttributes(Collection $attributes): void
    {
        $quantityRequiredAttributes = $attributes->keys()->filter(function ($key) {
            return in_array($key, $this->getRequiredAttributes());
        })->count();

        if ($quantityRequiredAttributes !== count($this->getRequiredAttributes())) {
            throw new NotAllRequiredAttributesException();
        }
    }

    protected function getRequiredAttributes(): array
    {
        return [
            'id',
            'auth_date',
            'hash',
        ];
    }

    protected function getAllowAttributes(): array
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
