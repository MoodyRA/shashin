<?php

namespace App\Domain\File;

use App\Domain\File\Entity\File;

interface FileStorageInterface
{
    /**
     * Déplace un fichier source vers la destination indiqué dans $file.
     *
     * @param string $source
     * @param File   $file
     * @return void
     * @throws FileStorageException
     */
    public function move(string $source, File $file): void;
}