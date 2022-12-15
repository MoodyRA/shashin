<?php

declare(strict_types=1);

namespace Shashin\File\UseCase\MoveFileToStorage;

use Shashin\Common\Error\ResponseError;
use Shashin\File\Enum\FileError;
use Shashin\File\FileStorageException;
use Shashin\File\FileStorageInterface;
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
    public function execute(
        MoveFileToStorageRequest $request,
        MoveFileToStoragePresenter $presenter
    ): void {
        $response = new MoveFileToStorageResponse();
        $isValid = $this->checkRequest($request, $response);
        if ($isValid) {
            try {
                $this->storage->move($request->getSourcePath(), $request->getFile());
            } catch (FileStorageException $e) {
                $response->addError(
                    new ResponseError(FileError::FILE_MOVE_FAILED->value)
                );
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
            $response->addError(
                new ResponseError(FileError::FILE_NOT_FOUND->value)
            );
            return false;
        }
    }
}