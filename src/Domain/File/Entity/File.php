<?php

namespace App\Domain\File\Entity;

use App\Domain\File\FileStorageInterface;
use DateTime;
use Moody\ValueObject\Identity\Uuid;

class File
{
    /**
     * @param Uuid                 $id
     * @param string               $name
     * @param string               $extension
     * @param int                  $size
     * @param string               $content
     * @param FileStorageInterface $storage
     * @param DateTime             $addedTime
     */
    public function __construct(
        protected Uuid $id,
        protected string $name,
        protected string $extension,
        protected int $size,
        protected string $content,
        protected FileStorageInterface $storage,
        protected DateTime $addedTime = new DateTime('now')
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
     * @param Uuid $id
     * @return File
     */
    public function setId(Uuid $id): File
    {
        $this->id = $id;
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
     * @return File
     */
    public function setName(string $name): File
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return File
     */
    public function setExtension(string $extension): File
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return File
     */
    public function setSize(int $size): File
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return File
     */
    public function setContent(string $content): File
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return FileStorageInterface
     */
    public function getStorage(): FileStorageInterface
    {
        return $this->storage;
    }

    /**
     * @param FileStorageInterface $storage
     * @return File
     */
    public function setStorage(FileStorageInterface $storage): File
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getAddedTime(): DateTime
    {
        return $this->addedTime;
    }

    /**
     * @param DateTime $addedTime
     * @return File
     */
    public function setAddedTime(DateTime $addedTime): File
    {
        $this->addedTime = $addedTime;
        return $this;
    }
}