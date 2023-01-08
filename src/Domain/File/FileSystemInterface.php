<?php

namespace Shashin\File;

use Shashin\File\Entity\File;

interface FileSystemInterface
{
    /**
     * Ajoute un fichier à la destination indiqué dans $file.
     *
     * @param string $source
     * @param File   $file
     * @return void
     * @throws FileSystemException
     */
    public function add(string $source, File $file): void;
}