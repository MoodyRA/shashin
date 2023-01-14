<?php

namespace Shashin\Common\Error;

use Shashin\Common\Exception\UnexpectedValueException;

class ErrorMessage
{
    /**
     * @param string $message
     * @throws UnexpectedValueException
     */
    public function __construct(private readonly string $message)
    {
        if (empty($message)) {
            throw new UnexpectedValueException('Message cannot be empty');
        }
        if (!preg_match('/^[a-z._]+$/', $message)) {
            throw new UnexpectedValueException('Message must contains only letters, dots and underscores');
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}