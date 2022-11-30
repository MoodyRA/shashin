<?php

declare(strict_types=1);

namespace App\Presentation\Notification;

class ConsoleNotification
{
    public function __construct(
        private ConsoleNotificationType $type,
        private string $message
    ) {
    }

    /**
     * @return ConsoleNotificationType
     */
    public function getType(): ConsoleNotificationType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}