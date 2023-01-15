<?php

declare(strict_types=1);

namespace Shashin\User\UseCase\RegisterAsAdmin;

interface RegisterAsAdminPresenter
{
    /**
     * @param RegisterAsAdminResponse $response
     * @return void
     */
    public function present(RegisterAsAdminResponse $response): void;
}