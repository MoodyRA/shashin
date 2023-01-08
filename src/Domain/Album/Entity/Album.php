<?php

namespace Shashin\Album\Entity;

use DateTime;
use Ramsey\Uuid\Uuid;
use Shashin\Common\Entity\SerializableEntity;
use Shashin\Photo\Collection\PhotoCollection;

class Album extends SerializableEntity
{
    /** @var DateTime */
    protected DateTime $createdAt;
    /** @var DateTime */
    protected DateTime $updatedAt;
    protected PhotoCollection $photos;

    /**
     * @param Uuid                 $id
     * @param string               $name
     * @param PhotoCollection|null $photos
     */
    public function __construct(protected Uuid $id, protected string $name, ?PhotoCollection $photos = null)
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->photos = $photos ?? new PhotoCollection([]);
    }
}