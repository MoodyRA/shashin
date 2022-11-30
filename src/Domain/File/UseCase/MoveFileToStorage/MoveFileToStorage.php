<?php

declare(strict_types=1);

namespace App\Domain\File\UseCase\MoveFileToStorage;

use App\Domain\File\Enum\FileError;
use App\Domain\File\FileStorageException;
use App\Domain\File\FileStorageInterface;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class MoveFileToStorage
{
    /**
     * @param FileStorageInterface $storage
     */
    public function __construct(
        private FileStorageInterface $storage
    ) {
    }

    /**
     * @param MoveFileToStorageRequest   $request
     * @param MoveFileToStoragePresenter $presenter
     * @return void
     */
    public function execute(MoveFileToStorageRequest $request, MoveFileToStoragePresenter $presenter)
    {
        $response = new MoveFileToStorageResponse();
        $isValid = $this->checkRequest($request, $response);
        if ($isValid) {
            try {
                $this->storage->move($request->getSourcePath(), $request->getFile());
            } catch (FileStorageException $e) {
                $response->addError(FileError::FILE_MOVE_FAILED);
            }
        }
        $presenter->present($response);
    }

    /**
     * @param MoveFileToStorageRequest  $request
     * @param MoveFileToStorageResponse $response
     * @return bool
     */
    private function checkRequest(MoveFileToStorageRequest $request, MoveFileToStorageResponse $response): bool
    {
        try {
            Assert::fileExists($request->getSourcePath());
            return true;
        } catch (InvalidArgumentException $e) {
            $response->addError(FileError::FILE_NOT_FOUND);
            return false;
        }
    }
}