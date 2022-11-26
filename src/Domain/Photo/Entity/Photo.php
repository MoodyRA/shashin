<?php

namespace App\Domain\Photo\Entity;

use App\Domain\Photo\Enum\PhotoExtension;
use DateTime;
use Moody\ValueObject\Identity\Uuid;

class Photo
{
    /**
     * @param Uuid           $id
     * @param string         $name
     * @param PhotoExtension $extension
     * @param int            $size
     * @param string         $content
     * @param DateTime       $addedTime
     */
    public function __construct(
        private Uuid $id,
        private string $name,
        private PhotoExtension $extension,
        private int $size,
        private string $content,
        private DateTime $addedTime = new \DateTime()
    ) {
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PhotoExtension
     */
    public function getExtension(): PhotoExtension
    {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getAddedTime(): DateTime
    {
        return $this->addedTime;
    }
}