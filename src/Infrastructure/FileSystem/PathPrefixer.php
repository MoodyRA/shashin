<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage;


final class PathPrefixer
{
    /**
     * @param string $prefix
     * @param string $separator
     */
    public function __construct(private string $prefix = '', private string $separator = '/')
    {
        $this->prefix = rtrim($prefix, '\\/');

        if ($this->prefix !== '' || $prefix === $separator) {
            $this->prefix .= $separator;
        }
    }

    /**
     * @param string $path
     * @return string
     */
    public function prefixPath(string $path): string
    {
        return $this->prefix . ltrim($path, '\\/');
    }

    /**
     * @param string $path
     * @return string
     */
    public function stripPrefix(string $path): string
    {
        /* @var string */
        return substr($path, strlen($this->prefix));
    }

    /**
     * @param string $path
     * @return string
     */
    public function prefixDirectoryPath(string $path): string
    {
        $prefixedPath = $this->prefixPath(rtrim($path, '\\/'));

        if ($prefixedPath === '' || substr($prefixedPath, -1) === $this->separator) {
            return $prefixedPath;
        }
        return $prefixedPath . $this->separator;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}