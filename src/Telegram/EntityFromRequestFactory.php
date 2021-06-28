<?php

namespace Azate\LaravelTelegramLoginAuth\Telegram;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\EntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final class EntityFromRequestFactory extends AbstractEntityFactory implements EntityFactory
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create(): EntityContract
    {
        $attributes = $this->request->only($this->getAllowAttributes());
        $attributesCollection = $this->createAttributesCollection($attributes);

        $entity = new Entity();
        $entity->setId($attributesCollection->get('id'));
        $entity->setFirstName($attributesCollection->get('first_name'));
        $entity->setLastName($attributesCollection->get('last_name'));
        $entity->setUsername($attributesCollection->get('username'));
        $entity->setPhotoUrl($attributesCollection->get('photo_url'));
        $entity->setAuthDate(Carbon::createFromTimestampUTC($attributesCollection->get('auth_date')));
        $entity->setHash($attributesCollection->get('hash'));

        return $entity;
    }
}
