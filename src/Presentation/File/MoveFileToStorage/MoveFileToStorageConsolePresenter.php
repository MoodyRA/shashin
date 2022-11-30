<?php

declare(strict_types=1);

namespace App\Presentation\File\MoveFileToStorage;

use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStoragePresenter;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorageResponse;
use App\Presentation\ErrorMessage\FileErrorMessage;
use App\Presentation\Notification\ConsoleNotification;
use App\Presentation\Notification\ConsoleNotificationType;

class MoveFileToStorageConsolePresenter implements MoveFileToStoragePresenter
{
    /** @var MoveFileToStorageConsoleViewModel */
    private MoveFileToStorageConsoleViewModel $viewModel;

    public function __construct(private string $lang = 'en')
    {
    }

    /**
     * @param MoveFileToStorageResponse $response
     * @return void
     */
    public function present(MoveFileToStorageResponse $response): void
    {
        $message = new FileErrorMessage($this->lang);
        $this->viewModel = new MoveFileToStorageConsoleViewModel();
        foreach ($response->getErrors() as $error) {
            $this->viewModel->addNotification(
                new ConsoleNotification(ConsoleNotificationType::ERROR, $message->get($error))
            );
        }
    }

    /**
     * @return MoveFileToStorageConsoleViewModel
     */
    public function viewModel(): MoveFileToStorageConsoleViewModel
    {
        return $this->viewModel;
    }
}