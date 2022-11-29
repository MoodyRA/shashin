<?php

declare(strict_types=1);

namespace App\Domain\File\UseCase\MoveFileToStorage;

class MoveFileToStorageResponse
{
    /** @var array */
    private array $errors = [];

    /**
     * @param string $error
     * @return void
     */
    public function addError(string $error)
    {
        $this->errors[] = $error;
    }
}