<?php

declare(strict_types=1);

namespace Shashin\File\UseCase\MoveFileToStorage;

interface MoveFileToStoragePresenter
{
    /**
     * @param MoveFileToStorageResponse $response
     * @return void
     */
    public function present(MoveFileToStorageResponse $response): void;
}