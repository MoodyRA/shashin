<?php

declare(strict_types=1);

namespace App\Domain\Photo\Entity;

use App\Domain\File\Entity\File;
use UnexpectedValueException;

class Photo extends File
{
    /**
     * @return void
     * @throws UnexpectedValueException
     */
    protected function verifyType(): void
    {
        if (!$this->type->isImageType()) {
            throw new UnexpectedValueException(
                "Photo instance must have an image type (" . implode(',', $this->type->imageTypeValues()) . ")"
            );
        }
    }
}