<?php

declare(strict_types=1);

namespace App\Infrastructure\FileStorage;

enum UnixFilePermission: int
{
    case PUBLIC_FILE_PERMISSION = 0644;
    case PRIVATE_FILE_PERMISSION = 0600;
    case PUBLIC_DIRECTORY_PERMISSION = 0755;
    case PRIVATE_DIRECTORY_PERMISSION = 0700;
}