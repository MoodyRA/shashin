<?php

namespace Shashin\Photo\Collection;

use Ramsey\Collection\AbstractCollection;
use Shashin\Photo\Entity\Photo;

/**
 * @extends AbstractCollection<Photo>
 */
class PhotoCollection extends AbstractCollection
{
    /**
     * @param Photo[] $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return Photo::class;
    }
}