<?php

namespace Shashin\User\UseCase\Login;

use Moody\ValueObject\Auth\PlainPassword;
use Moody\ValueObject\Web\EmailAddress;

class LoginRequest
{
    /**
     * @param EmailAddress  $email
     * @param PlainPassword $password
     */
    public function __construct(
        private readonly EmailAddress $email,
        private readonly PlainPassword $password,
    ) {
    }

    /**
     * @return EmailAddress
     */
    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    /**
     * @return PlainPassword
     */
    public function getPassword(): PlainPassword
    {
        return $this->password;
    }
}