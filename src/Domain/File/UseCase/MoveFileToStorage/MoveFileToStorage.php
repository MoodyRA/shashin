<?php

declare(strict_types=1);

namespace Shashin\File\UseCase\MoveFileToStorage;

use Shashin\Shared\Error\ResponseError;
use Shashin\File\Enum\FileError;
use Shashin\File\FileSystemException;
use Shashin\File\FileSystemInterface;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class MoveFileToStorage
{
    /**
     * @param FileSystemInterface $storage
     */
    public function __construct(
        private FileSystemInterface $storage
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
                $this->storage->add($request->getSourcePath(), $request->getFile());
            } catch (FileSystemException $e) {
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