<?php

namespace Shashin\Shared\UseCase;

use Shashin\Shared\Error\ResponseError;

/**
 * Gère les erreurs pour les réponses de use case
 */
abstract class AbstractErrorResponse
{
    /** @var ResponseError[] */
    private array $errors = [];

    /**
     * @param ResponseError $error
     * @return void
     */
    public function addError(ResponseError $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return ResponseError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}