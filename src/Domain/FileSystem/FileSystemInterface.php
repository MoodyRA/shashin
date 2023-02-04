<?php

namespace Shashin\FileSystem;

use Shashin\Shared\Exception\FileSystemException;
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
     * @param SplFileInfo $file
     * @return void
     * @throws FileSystemException
     */
    public function remove(SplFileInfo $file): void;

    /**
     * @param SplFileInfo $file
     * @return bool
     */
    public function fileExists(SplFileInfo $file): bool;

    /**
     * Doit retourner le chemin du dossier racine du file system. Ne doit pas contenir de séparateur à la fin.
     *
     * @return string
     */
    public function getRootPath(): string;

    /**
     * @return string
     */
    public function getDirectorySeparator(): string;
}