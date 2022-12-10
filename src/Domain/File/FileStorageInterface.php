<?php

namespace Shashin\File;

use Shashin\File\Entity\File;

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