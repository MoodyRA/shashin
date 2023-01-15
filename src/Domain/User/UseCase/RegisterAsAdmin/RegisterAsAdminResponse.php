<?php

namespace Shashin\User\UseCase\RegisterAsAdmin;

use Shashin\User\Entity\User;
use Shashin\Shared\UseCase\AbstractErrorResponse;

class RegisterAsAdminResponse extends AbstractErrorResponse
{
    private ?User $user;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}