<?php

declare(strict_types=1);

namespace Shashin\Tests\User\Entity;

use Moody\ValueObject\Auth\HashedPassword;
use Moody\ValueObject\Auth\PlainPassword;
use Moody\ValueObject\ValueObjectIncorrectValueException;
use Moody\ValueObject\Web\EmailAddress;
use Shashin\User\Entity\User;
use Shashin\User\Model\Credentials;

class UserBuilder
{
    /**
     * @param bool $isAdmin
     * @return User
     * @throws ValueObjectIncorrectValueException
     * @throws \RuntimeException
     */
    public static function createUser(bool $isAdmin = false): User
    {
        $credential = new Credentials(
            new EmailAddress('moody@mail.com'),
            HashedPassword::fromPlain(PlainPassword::fromString('MyCorrect_Password8'))
        );
        return new User(
            $credential,
            'Moody',
            $isAdmin
        );
    }
}