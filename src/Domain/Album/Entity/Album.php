<?php

namespace Shashin\Album\Entity;

use DateTime;
use Moody\ValueObject\Identity\Uuid;
use Shashin\Common\Entity\Entity;
use Shashin\Photo\Collection\PhotoCollection;

class Album extends Entity
{
    /** @var DateTime */
    protected DateTime $createdAt;
    /** @var DateTime */
    protected DateTime $updatedAt;
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Album
     */
    public function setCreatedAt(DateTime $createdAt): Album
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Album
     */
    public function setUpdatedAt(DateTime $updatedAt): Album
    {
        $this->updatedAt = $updatedAt;
        return $this;
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