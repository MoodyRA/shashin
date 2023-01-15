<?php

namespace Shashin\Domain\User\Entity;

use Shashin\Domain\User\Model\Credential;
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