<?php

namespace Shashin\Album\Entity;

use DateTime;
use Moody\ValueObject\Identity\Uuid;
use Shashin\Shared\Entity\Entity;
use Shashin\Photo\Collection\PhotoCollection;

class Album extends Entity
{
    /** @var PhotoCollection */
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

    /**
     * @return PhotoCollection
     */
    public function getPhotos(): PhotoCollection
    {
        return $this->photos;
    }

    /**
     * @param PhotoCollection $photos
     * @return Album
     */
    public function setPhotos(PhotoCollection $photos): Album
    {
        $this->photos = $photos;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Album
     */
    public function setName(string $name): Album
    {
        $this->name = $name;
        return $this;
    }
}