<?php

namespace Shashin\Common\Error;

use Shashin\Common\Exception\DomainException;

class ResponseError
{
    /**
     * @param ErrorMessage         $message
     * @param array<string,mixed>  $parameters
     * @param DomainException|null $exception
     */
    public function __construct(
        private readonly ErrorMessage $message,
        private readonly array $parameters = [],
        private readonly ?DomainException $exception = null
    ) {
    }

    /**
     * @return ErrorMessage
     */
    public function getMessage(): ErrorMessage
    {
        return $this->message;
    }

    /**
     * @return array<string,mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return null|DomainException
     */
    public function getException(): ?DomainException
    {
        return $this->exception;
    }
}