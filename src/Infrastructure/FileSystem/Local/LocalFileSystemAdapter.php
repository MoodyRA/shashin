<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage\Local;

use App\Infrastructure\FileStorage\PathPrefixer;
use App\Infrastructure\FileStorage\UnixFilePermission;
use Shashin\FileSystem\FileSystemInterface;
use Shashin\Shared\Exception\FileSystemException;
use SplFileInfo;

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
     * @param SplFileInfo $source
     * @param SplFileInfo $destination
     * @return void
     * @throws FileSystemException
     */
    public function add(SplFileInfo $source, SplFileInfo $destination): void
    {
        // $destination = $this->root->prefixPath($file->getFileName());
        $this->ensureRootDirectoryExists();
        $this->ensureDirectoryExists($destination->getPath(), UnixFilePermission::PUBLIC_DIRECTORY_PERMISSION);
        if (!$source->isFile()) {
            throw new FileSystemException("source file doesn't found", ['source' => $source->getPathname()]);
        }
        error_clear_last();
        if (!@rename($source->getPathname(), $destination->getPathname())) {
            throw new FileSystemException(
                "Error adding file",
                [
                    'source' => $source->getPathname(),
                    'destination' => $destination->getPathname(),
                    'last_error' => error_get_last() ?? ''
                ]
            );
        }
    }

    /**
     * @param SplFileInfo $file
     * @return void
     * @throws FileSystemException
     */
    public function remove(SplFileInfo $file): void
    {
        // pas forcément une erreur de vouloir supprimer un fichier inexistant, si c'est le cas on ne fait rien.
        if (!$file->isFile()) {
            return;
        }
        error_clear_last();
        if (!@unlink($file->getPathname())) {
            throw new FileSystemException(
                'Error deleting file',
                ['last_error' => error_get_last() ?? '', 'file' => $file->getPathname()]
            );
        }
    }

    /**
     * @param SplFileInfo $file
     * @return bool
     */
    public function fileExists(SplFileInfo $file): bool
    {
        return $file->isFile();
    }

    /**
     * @return string
     */
    public function getRootPath(): string
    {
        return rtrim($this->root->getPrefix(), '\\/');
    }

    /**
     * @return string
     */
    public function getDirectorySeparator(): string
    {
        return DIRECTORY_SEPARATOR;
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