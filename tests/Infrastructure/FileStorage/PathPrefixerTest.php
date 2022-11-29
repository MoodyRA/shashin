<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\FileStorage;

use App\Infrastructure\FileStorage\PathPrefixer;
use PHPUnit\Framework\TestCase;

class PathPrefixerTest extends TestCase
{
    /**
     * Le préfixe doit être vide sans "/"
     *
     * @return void
     */
    public function testInstanciateEmptyPath(): void
    {
        $pathPrefixer = new PathPrefixer('');
        $path = $pathPrefixer->prefixPath('');
        $path = $pathPrefixer->stripPrefix('/home/shashin/coucoucou');
        self::assertEquals('', $pathPrefixer->getPrefix());
    }

    /**
     * Doit renvoyer le préfix avec un "/" à la fin.
     *
     * @return void
     */
    public function testInstanciateFilledPathWithoutEndSeparator(): void
    {
        $pathPrefixer = new PathPrefixer('/home');
        self::assertEquals('/home/', $pathPrefixer->getPrefix());
    }

    /**
     * Doit renvoyer le préfix avec un "/" à la fin.
     *
     * @return void
     */
    public function testInstanciateFilledPathWithEndSeparator(): void
    {
        $pathPrefixer = new PathPrefixer('/home/');
        self::assertEquals('/home/', $pathPrefixer->getPrefix());
    }

    /**
     * Doit renvoyer le préfix avec le séparateur custom à la fin.
     *
     * @return void
     */
    public function testInstanciateFilledPathWithCustomSeparator(): void
    {
        $separator = '§';
        $pathPrefixer = new PathPrefixer('/home/', $separator);
        self::assertEquals('/home' . $separator, $pathPrefixer->getPrefix());
    }

    /**
     * Doit renvoyer un chemin absolu en combinant le préfixe et le chemin relatif
     *
     * @return void
     */
    public function testPrefixPath(): void
    {
        $pathPrefixer = new PathPrefixer('/home/');
        $fullPath = $pathPrefixer->prefixPath('my/full/path');
        self::assertEquals('/home/my/full/path', $fullPath);
    }

    /**
     * Doit renvoyer un chemin absolu en combinant le préfixe et le chemin relatif. Le chemin doit forcément finir par
     * un séparateur.
     *
     * @return void
     */
    public function testPrefixDirectoryPath(): void
    {
        $pathPrefixer = new PathPrefixer('/home/');
        $directoryFullPath = $pathPrefixer->prefixDirectoryPath('my/full/path/directory');
        self::assertEquals('/home/my/full/path/directory/', $directoryFullPath);
    }

    /**
     * Doit renvoyer la partie relative d'un chemin à partir d'un chemin absolu contenant le préfixe.
     *
     * @return void
     */
    public function testStripPath(): void
    {
        $pathPrefixer = new PathPrefixer('/home/');
        $relativePath = $pathPrefixer->stripPrefix($pathPrefixer->getPrefix() . 'my/relative/path');
        self::assertEquals('my/relative/path', $relativePath);
    }
}