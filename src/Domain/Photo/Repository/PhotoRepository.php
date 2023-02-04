<?php

namespace Shashin\Photo\Repository;

use Shashin\Photo\Collection\PhotoCollection;
use Shashin\Photo\Entity\Photo;
use Shashin\Shared\Exception\RepositoryException;

interface PhotoRepository
{
    /**
     * @param Photo $photo
     * @return void
     * @throws RepositoryException
     */
    public function create(Photo $photo): void;

    /**
     * @param PhotoCollection $photos
     * @return void
     * @throws RepositoryException
     */
    public function bulkCreate(PhotoCollection $photos): void;

    /**
     * @param Photo $photo
     * @return void
     * @throws RepositoryException
     */
    public function delete(Photo $photo): void;
}