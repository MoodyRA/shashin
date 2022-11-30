<?php

declare(strict_types=1);

namespace App\Presentation\Notification;

enum HtmlNotificationType
{
    case ERROR;
    case WARNING;
    case INFORMATION;
}