<?php

declare(strict_types=1);

namespace App\Domain\File\Entity;

use App\Domain\File\Enum\FileType;
use DateTime;
use Moody\ValueObject\Identity\Uuid;
use UnexpectedValueException;

class File
{
    /**
     * @param Uuid     $id
     * @param string   $name
     * @param FileType $type
     * @param string   $relativePath
     * @param int      $size
     * @param DateTime $addedTime
     * @throws UnexpectedValueException
     */
    public function __construct(
        protected Uuid $id,
        protected string $name,
        protected FileType $type,
        protected string $relativePath,
        protected int $size = 0,
        protected DateTime $addedTime = new DateTime('now')
    ) {
        $this->verifyType();
    }

    /**
     * @return void
     * @throws UnexpectedValueException
     */
    protected function verifyType(): void
    {
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
     * @return FileType
     */
    public function getType(): FileType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return DateTime
     */
    public function getAddedTime(): DateTime
    {
        return $this->addedTime;
    }

    /**
     * Chemin à utiliser pour enregister le fichier dans un système de stockage
     *
     * @return string
     */
    public function getFileName(): string
    {
        return rtrim($this->relativePath, '\\/') . '/' . $this->id->getValue() . $this->type->valueWithDot();
    }
}