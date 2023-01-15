<?php

namespace Shashin\User\Entity;

use Shashin\User\Model\Credential;
use Shashin\Shared\Exception\RepositoryException;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
     * @throws RepositoryException
     */

    public function create(User $user): void;

    /**
     * @param Credential $credential
     * @return bool
     * @throws RepositoryException
     */
    public function exists(Credential $credential): bool;
}