<?php

namespace App\Domain\File;

use App\Domain\File\Entity\File;

interface FileStorageInterface
{
    /**
     * @param File $file
     * @return void
     */
    public function add(File $file): void;

    /**
     * @param File $file
     * @return void
     */
    public function remove(File $file): void;
}