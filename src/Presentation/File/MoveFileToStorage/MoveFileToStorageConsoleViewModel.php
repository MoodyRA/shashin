<?php

declare(strict_types=1);

namespace App\Presentation\File\MoveFileToStorage;

use App\Presentation\Notification\ConsoleNotification;

class MoveFileToStorageConsoleViewModel
{
    /** @var ConsoleNotification[] */
    private array $notifications = [];

    /**
     * @param ConsoleNotification $notification
     * @return void
     */
    public function addNotification(ConsoleNotification $notification): void
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return ConsoleNotification[]
     */
    public function getNotifications(): array
    {
        return $this->notifications;
    }
}