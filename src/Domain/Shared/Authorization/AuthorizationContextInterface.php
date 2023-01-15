<?php

namespace Shashin\Shared\Authorization;

use Shashin\User\Entity\User;

interface AuthorizationContextInterface
{
    /**
     * @return bool
     */
    public function isRequesterAdmin(): bool;

    /**
     * @return User
     */
    public function getRequester(): User;
}