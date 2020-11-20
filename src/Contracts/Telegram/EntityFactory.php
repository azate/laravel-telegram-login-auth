<?php

namespace Azate\LaravelTelegramLoginAuth\Contracts\Telegram;

interface EntityFactory
{
    public function create(): Entity;
}
