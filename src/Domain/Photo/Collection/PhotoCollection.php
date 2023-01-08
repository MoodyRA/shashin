<?php

namespace Shashin\Photo\Collection;

use Ramsey\Collection\Collection;
use Shashin\Photo\Entity\Photo;

class PhotoCollection
{
    /**
     * @param Photo[] $photos
     */
    public function __construct(private array $photos)
    {
    }

    /**
     * @return Photo[]
     */
    public function all(): array
    {
        return $this->photos;
    }
}