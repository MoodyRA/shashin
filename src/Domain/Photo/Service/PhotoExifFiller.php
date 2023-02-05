<?php

namespace Shashin\Photo\Service;

use Shashin\Lens\ValueObject\FocalLenght;
use Shashin\Photo\Entity\Photo;

class PhotoExifFiller
{
    private ExifReader $reader;

    /**
     * @param Photo $photo
     */
    public function __construct(private Photo $photo)
    {
        $this->reader = new ExifReader($photo->getFile()->getPathname());
    }

    /**
     * Rempli l'ensemble des propriétés de la photo pouvant être alimentées par les données EXIF
     *
     * @return void
     */
    public function fill(): void
    {
        $this->fillPhotoFocalLength();
        // todo $this->fillPhotoExposure();
    }

    /**
     * @return void
     */
    public function fillPhotoFocalLength(): void
    {
        $focalLength = $this->reader->getFocalLength();
        if (!is_null($focalLength)) {
            $this->photo->setFocalLength(new FocalLenght($focalLength));
        }
    }
}