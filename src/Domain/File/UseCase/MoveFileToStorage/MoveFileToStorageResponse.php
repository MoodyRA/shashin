<?php

declare(strict_types=1);

namespace App\Domain\File\UseCase\MoveFileToStorage;

use App\Domain\File\Enum\FileError;

class MoveFileToStorageResponse
{
    /** @var FileError[] */
    private array $errors = [];

    /**
     * @param FileError $error
     * @return void
     */
    public function addError(FileError $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}