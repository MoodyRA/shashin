<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage\Local;

use App\Domain\File\Entity\File;
use App\Domain\File\FileStorageException;
use App\Domain\File\FileStorageInterface;
use App\Infrastructure\FileStorage\PathPrefixer;
use App\Infrastructure\FileStorage\UnixFilePermission;

class LocalFileStorageAdapter implements FileStorageInterface
{
    /** @var PathPrefixer */
    private PathPrefixer $root;

    /**
     * @param string $rootPath
     */
    public function __construct(string $rootPath)
    {
        $this->root = new PathPrefixer($rootPath, DIRECTORY_SEPARATOR);
    }

    /**
     * @param string $source
     * @param File   $file
     * @return void
     * @throws FileStorageException
     */
    public function move(string $source, File $file): void
    {
        $destination = $this->root->prefixPath($file->getFileName());
        $this->ensureRootDirectoryExists();
        $this->ensureDirectoryExists(dirname($destination), UnixFilePermission::PUBLIC_DIRECTORY_PERMISSION);
        if (!is_file($source)) {
            throw new FileStorageException("source file doesn't exist : $source");
        }
        if (!@rename($source, $destination)) {
            throw new FileStorageException("File move fail");
        }
    }

    /**
     * @return void
     * @throws FileStorageException
     */
    private function ensureRootDirectoryExists(): void
    {
        $this->ensureDirectoryExists(
            $this->root->prefixPath('/'),
            UnixFilePermission::PUBLIC_DIRECTORY_PERMISSION
        );
    }

    /**
     * Vérifie qu'un dossier existe, sinon on le créé.
     *
     * @param string             $dirname
     * @param UnixFilePermission $permission
     * @return void
     * @throws FileStorageException
     */
    private function ensureDirectoryExists(string $dirname, UnixFilePermission $permission): void
    {
        if (is_dir($dirname)) {
            return;
        }

        error_clear_last();

        if (!@mkdir($dirname, $permission->value, true)) {
            $mkdirError = error_get_last();
        }

        clearstatcache(true, $dirname);

        if (!is_dir($dirname)) {
            $errorMessage = $mkdirError['message'] ?? '';

            throw new FileStorageException("Unable to create directory at $dirname. $errorMessage");
        }
    }
}