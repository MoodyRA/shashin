<?php

declare(strict_types=1);

namespace Shashin\Domain\User\Entity;

use Shashin\Domain\User\Model\Credential;
use Shashin\Shared\Entity\Entity;

class User extends Entity
{
    public function __construct(
        protected Credential $credential,
        protected string $name,
        protected bool $isAdmin = false,
    ) {
    }

    /**
     * @return Credential
     */
    public function getCredential(): Credential
    {
        return $this->credential;
    }

    /**
     * @param Credential $credential
     * @return User
     */
    public function setCredential(Credential $credential): User
    {
        $this->credential = $credential;
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
            'email' => $this->credential->getEmail()->getValue(),
            'name' => $this->name,
            'isAdmin' => $this->isAdmin
        ];
    }
}