<?php

namespace Shashin\User\UseCase\Login;

use Shashin\Shared\UseCase\AbstractErrorResponse;
use Shashin\User\Entity\User;

class LoginResponse extends AbstractErrorResponse
{
    /**
     * @var User|null $user
     */
    private ?User $user = null;

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