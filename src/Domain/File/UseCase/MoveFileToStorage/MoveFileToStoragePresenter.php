<?php

declare(strict_types=1);

namespace App\Domain\File\UseCase\MoveFileToStorage;

interface MoveFileToStoragePresenter
{
    /**
     * @param MoveFileToStorageResponse $response
     * @return mixed
     */
    public function present(MoveFileToStorageResponse $response);
}