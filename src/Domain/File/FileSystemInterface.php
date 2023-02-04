<?php

namespace Shashin\File;

use SplFileInfo;

interface FileSystemInterface
{
    /**
     * Ajoute un fichier à la destination indiqué dans $file.
     *
     * @param SplFileInfo $source
     * @param SplFileInfo $destination
     * @return void
     * @throws FileSystemException
     */
    public function add(SplFileInfo $source, SplFileInfo $destination): void;

    /**
     * Doit retourner le chemin du dossier racine du file system. Ne doit pas contenir de séparateur à la fin.
     *
     * @return string
     */
    public function getRootPath(): string;
}