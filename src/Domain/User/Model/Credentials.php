<?php

namespace Shashin\User\Model;

use Moody\ValueObject\Auth\HashedPassword;
use Moody\ValueObject\Web\EmailAddress;
use Shashin\Shared\Trait\SerializableObject;

class Credentials
{
    use SerializableObject;

    /**
     * @param EmailAddress   $email
     * @param HashedPassword $password
     */
    public function __construct(protected EmailAddress $email, protected HashedPassword $password)
    {
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
     * @return Credentials
     */
    public function setEmail(EmailAddress $email): Credentials
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
     * @return Credentials
     */
    public function setPassword(HashedPassword $password): Credentials
    {
        $this->password = $password;
        return $this;
    }
}