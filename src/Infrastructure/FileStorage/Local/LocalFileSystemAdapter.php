<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage\Local;

use Shashin\File\Entity\File;
use Shashin\File\FileSystemException;
use Shashin\File\FileSystemInterface;
use App\Infrastructure\FileStorage\PathPrefixer;
use App\Infrastructure\FileStorage\UnixFilePermission;

class LocalFileSystemAdapter implements FileSystemInterface
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
     * @throws FileSystemException
     */
    public function add(string $source, File $file): void
    {
        $destination = $this->root->prefixPath($file->getFileName());
        $this->ensureRootDirectoryExists();
        $this->ensureDirectoryExists(dirname($destination), UnixFilePermission::PUBLIC_DIRECTORY_PERMISSION);
        if (!is_file($source)) {
            throw new FileSystemException("source file doesn't exist : $source");
        }
        if (!@rename($source, $destination)) {
            throw new FileSystemException("File move fail");
        }
    }

    /**
     * @return void
     * @throws FileSystemException
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
     * @throws FileSystemException
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

            throw new FileSystemException("Unable to create directory at $dirname. $errorMessage");
        }
    }
}