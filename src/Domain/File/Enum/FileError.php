<?php

declare(strict_types=1);

namespace App\Domain\File\Enum;

use App\Domain\Common\Enum\ErrorEnumInterface;

enum FileError implements ErrorEnumInterface
{
    case FILE_MOVE_FAILED;
    case FILE_NOT_FOUND;
}