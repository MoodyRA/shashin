<?php

namespace Shashin\User\Entity;

use Moody\ValueObject\Web\EmailAddress;
use Shashin\User\Model\Credentials;
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
     * @param Credentials $credentials
     * @return bool
     * @throws RepositoryException
     */
    public function exists(Credentials $credentials): bool;

    /**
     * @param EmailAddress $email
     * @return User|null
     * @throws RepositoryException
     */
    public function findByEmail(EmailAddress $email): ?User;
}