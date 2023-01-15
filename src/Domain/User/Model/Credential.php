<?php

namespace Shashin\User\Model;

use Moody\ValueObject\Auth\HashedPassword;
use Moody\ValueObject\Web\EmailAddress;

class Credential
{
    public function __construct(
        protected EmailAddress $email,
        protected HashedPassword $password
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
     * @param EmailAddress $email
     * @return Credential
     */
    public function setEmail(EmailAddress $email): Credential
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return HashedPassword
     */
    public function getPassword(): HashedPassword
    {
        return $this->password;
    }

    /**
     * @param HashedPassword $password
     * @return Credential
     */
    public function setPassword(HashedPassword $password): Credential
    {
        $this->password = $password;
        return $this;
    }
}