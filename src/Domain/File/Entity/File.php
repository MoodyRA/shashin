<?php

declare(strict_types=1);

namespace App\Domain\File\Entity;

use App\Domain\File\Enum\FileType;
use App\Domain\File\FileStorageInterface;
use DateTime;
use Moody\ValueObject\Identity\Uuid;
use UnexpectedValueException;

class File
{
    /**
     * @param Uuid                 $id
     * @param string               $name
     * @param FileType             $type
     * @param string               $relativePath
     * @param int                  $size
     * @param FileStorageInterface $storage
     * @param DateTime             $addedTime
     * @throws UnexpectedValueException
     */
    public function __construct(
        protected Uuid $id,
        protected string $name,
        protected FileType $type,
        protected string $relativePath,
        protected int $size,
        protected FileStorageInterface $storage,
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
}