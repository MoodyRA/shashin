<?php

declare(strict_types=1);

namespace App\Domain\File\Enum;

enum FileError: string
{
    case FILE_MOVE_FAILED = 'file.move.failed';
    case FILE_NOT_FOUND = 'file.not.found';
}