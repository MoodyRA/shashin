<?php

declare(strict_types=1);

namespace Shashin\Photo\Entity;

use Shashin\File\Entity\File;
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