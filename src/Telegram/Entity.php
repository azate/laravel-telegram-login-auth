<?php

namespace Azate\LaravelTelegramLoginAuth\Telegram;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Carbon\CarbonInterface;

final class Entity implements EntityContract
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $photoUrl;

    /**
     * @var CarbonInterface
     */
    private $authDate;

    /**
     * @var string
     */
    private $hash;

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'username' => $this->getUsername(),
            'photo_url' => $this->getPhotoUrl(),
            'auth_date' => $this->getAuthDate()->unix(),
            'hash' => $this->getHash(),
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }

    public function getAuthDate(): CarbonInterface
    {
        return $this->authDate->copy();
    }

    public function setAuthDate(CarbonInterface $authDate): void
    {
        $this->authDate = $authDate;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }
}
