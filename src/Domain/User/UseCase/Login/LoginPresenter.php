<?php

namespace Shashin\User\UseCase\Login;

interface LoginPresenter
{
    /**
     * @param LoginResponse $response
     * @return void
     */
    public function present(LoginResponse $response): void;
}