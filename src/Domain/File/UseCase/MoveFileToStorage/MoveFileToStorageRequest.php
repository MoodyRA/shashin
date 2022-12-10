<?php

declare(strict_types=1);

namespace Shashin\File\UseCase\MoveFileToStorage;

use Shashin\File\Entity\File;

class MoveFileToStorageRequest
{
    /**
     * @param string $sourcePath
     * @param File   $file
     */
    public function __construct(
        private readonly string $sourcePath,
        private readonly File $file
    ) {
    }

    /**
     * @return string
     */
    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}