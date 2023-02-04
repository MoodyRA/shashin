<?php

namespace Shashin\Photo\UseCase\AddPhotos;

use Shashin\Photo\Collection\PhotoCollection;

class AddPhotosRequest
{
    /**
     * @param PhotoCollection $photos
     */
    public function __construct(
        private PhotoCollection $photos
    ) {
    }

    /**
     * @return PhotoCollection
     */
    public function getPhotos(): PhotoCollection
    {
        return $this->photos;
    }
}