<?php

namespace Shashin\Shared\Error;

use Shashin\Shared\Exception\DomainException;

class ResponseError
{
    /**
     * @param string               $message
     * @param array<string,mixed>  $parameters
     * @param DomainException|null $exception
     */
    public function __construct(
        private readonly string $message,
        private readonly array $parameters = [],
        private readonly ?DomainException $exception = null
    ) {
    }

    /**
     * @return string
     */
    public function getMessage(): string
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