<?php

declare(strict_types=1);

namespace Shashin\Photo\Entity;

use DateTime;
use Moody\ValueObject\Identity\Uuid;
use Shashin\Camera\Entity\Camera;
use Shashin\File\Enum\FileExtension;
use Shashin\Lens\Entity\Lens;
use Shashin\Lens\ValueObject\FocalLenght;
use Shashin\Photo\Model\Exposure;
use Shashin\Shared\Entity\Entity;
use Shashin\Shared\Exception\UnexpectedValueException;
use SplFileInfo;

class Photo extends Entity
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
     * @param Uuid        $id
     * @param SplFileInfo $file
     * @param DateTime    $addedTime
     * @throws UnexpectedValueException
     */
    public function __construct(
        Uuid $id,
        protected SplFileInfo $file,
        protected DateTime $addedTime = new DateTime('now')
    ) {
        $extension = FileExtension::fromFileName($file->getFilename());
        if (!$extension->isImageType()) {
            throw new UnexpectedValueException(
                "Photo instance must have an image extension (" . implode(',', $extension->imageTypeValues()) . ")"
            );
        }
        $this->id = $id;
    }

    /**
     * @return Exposure|null
     */
    public function getExposure(): ?Exposure
    {
        return $this->exposure;
    }

    /**
     * @param Exposure|null $exposure
     * @return Photo
     */
    public function setExposure(?Exposure $exposure): Photo
    {
        $this->exposure = $exposure;
        return $this;
    }

    /**
     * @return Camera|null
     */
    public function getCamera(): ?Camera
    {
        return $this->camera;
    }

    /**
     * @param Camera|null $camera
     * @return Photo
     */
    public function setCamera(?Camera $camera): Photo
    {
        $this->camera = $camera;
        return $this;
    }

    /**
     * @return Lens|null
     */
    public function getLens(): ?Lens
    {
        return $this->lens;
    }

    /**
     * @param Lens|null $lens
     * @return Photo
     */
    public function setLens(?Lens $lens): Photo
    {
        $this->lens = $lens;
        return $this;
    }

    /**
     * @return FocalLenght|null
     */
    public function getFocalLength(): ?FocalLenght
    {
        return $this->focalLength;
    }

    /**
     * @param FocalLenght|null $focalLength
     * @return Photo
     */
    public function setFocalLength(?FocalLenght $focalLength): Photo
    {
        $this->focalLength = $focalLength;
        return $this;
    }

    /**
     * @return SplFileInfo
     */
    public function getFile(): SplFileInfo
    {
        return $this->file;
    }

    /**
     * @param SplFileInfo $file
     * @return $this
     */
    public function setFile(SplFileInfo $file): Photo
    {
        $this->file = $file;
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
     * @return Photo
     */
    public function setAddedTime(DateTime $addedTime): Photo
    {
        $this->addedTime = $addedTime;
        return $this;
    }

    /**
     * Le nom du fichier sur le filesystem est composé de l'identifiant de la photo et de son extension
     *
     * @return string
     */
    public function fileNameForFileSystem(): string
    {
        return $this->id->getValue() . '.' . $this->file->getExtension();
    }
}