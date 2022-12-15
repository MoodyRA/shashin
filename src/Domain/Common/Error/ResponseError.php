<?php

namespace Shashin\Common\Error;

class ResponseError
{
    public function __construct(
        private string $message,
        private array $parameters = []
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
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}