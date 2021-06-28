<?php

namespace Azate\LaravelTelegramLoginAuth\Contracts\Telegram;

use Carbon\CarbonInterface;

interface Entity
{
    public function toArray(): array;

    public function getId(): string;

    public function setId(string $id): void;

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getUsername(): ?string;

    public function setUsername(?string $username): void;

    public function getPhotoUrl(): ?string;

    public function setPhotoUrl(?string $photoUrl): void;

    public function getAuthDate(): CarbonInterface;

    public function setAuthDate(CarbonInterface $authDate): void;

    public function getHash(): string;

    public function setHash(string $hash): void;
}
