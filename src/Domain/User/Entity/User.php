<?php

declare(strict_types=1);

namespace Shashin\User\Entity;

use Shashin\User\Model\Credentials;
use Shashin\Shared\Entity\Entity;

class User extends Entity
{
    public function __construct(
        protected Credentials $credentials,
        protected string $name,
        protected bool $isAdmin = false,
    ) {
    }

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @param Credentials $credentials
     * @return User
     */
    public function setCredentials(Credentials $credentials): User
    {
        $this->credentials = $credentials;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin): User
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->credentials->getEmail()->getValue(),
            'name' => $this->name,
            'isAdmin' => $this->isAdmin
        ];
    }
}