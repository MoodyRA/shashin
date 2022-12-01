<?php

declare(strict_types=1);

namespace App\Presentation\File\MoveFileToStorage;

use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStoragePresenter;
use App\Domain\File\UseCase\MoveFileToStorage\MoveFileToStorageResponse;
use App\Presentation\Notification\ConsoleNotification;
use App\Presentation\Notification\ConsoleNotificationType;
use InvalidArgumentException;
use Symfony\Contracts\Translation\TranslatorInterface;

class MoveFileToStorageConsolePresenter implements MoveFileToStoragePresenter
{
    /** @var MoveFileToStorageConsoleViewModel */
    private MoveFileToStorageConsoleViewModel $viewModel;

    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param MoveFileToStorageResponse $response
     * @return void
     * @throws InvalidArgumentException
     */
    public function present(MoveFileToStorageResponse $response): void
    {
        $this->viewModel = new MoveFileToStorageConsoleViewModel();
        foreach ($response->getErrors() as $error) {
            $this->viewModel->addNotification(
                new ConsoleNotification(ConsoleNotificationType::ERROR, $this->translator->trans($error->value))
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