<?php

namespace App\Domain\Photo\Repository;

use App\Domain\Photo\Entity\Photo;

interface PhotoRepository
{
    /**
     * @param Photo $photo
     * @return void
     */
    public function save(Photo $photo): void;

    /**
     * @param Photo $photo
     * @return void
     */
    public function delete(Photo $photo): void;
}