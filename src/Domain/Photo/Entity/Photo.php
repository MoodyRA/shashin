<?php

declare(strict_types=1);

namespace Shashin\Photo\Entity;

use DateTime;
use Moody\ValueObject\Identity\Uuid;
use Shashin\Camera\Entity\Camera;
use Shashin\File\Entity\File;
use Shashin\File\Enum\FileType;
use Shashin\Lens\Entity\Lens;
use Shashin\Lens\ValueObject\FocalLenght;
use Shashin\Photo\Model\Exposure;
use UnexpectedValueException;

class Photo extends File
{
    /** @var Exposure|null */
    protected ?Exposure $exposure = null;
    /** @var Camera|null */
    protected ?Camera $camera = null;
    /** @var Lens|null */
    protected ?Lens $lens = null;
    /** @var FocalLenght|null */
    protected ?FocalLenght $focalLength = null;

    /**
     * @throws UnexpectedValueException
     */
    public function __construct(
        Uuid $id,
        string $name,
        FileType $type,
        string $relativePath,
        int $size = 0,
        DateTime $addedTime = new DateTime('now')
    ) {
        if (!$this->type->isImageType()) {
            throw new UnexpectedValueException(
                "Photo instance must have an image type (" . implode(',', $this->type->imageTypeValues()) . ")"
            );
        }
        parent::__construct($id, $name, $type, $relativePath, $size, $addedTime);
    }
}