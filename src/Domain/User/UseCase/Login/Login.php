<?php

declare(strict_types=1);

namespace Shashin\User\UseCase\Login;

use Shashin\Shared\Error\ErrorMessage;
use Shashin\Shared\Error\ResponseError;
use Shashin\Shared\Exception\RepositoryException;
use Shashin\User\Entity\UserRepositoryInterface;
use Shashin\User\Enum\UserError;

class Login
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param LoginRequest   $request
     * @param LoginPresenter $presenter
     * @return void
     */
    public function execute(LoginRequest $request, LoginPresenter $presenter): void
    {
        $response = new LoginResponse();
        try {
            $user = $this->userRepository->findByEmail($request->getEmail());
            if (!is_null($user)) {
                $isPasswordCorrect = $user->getCredentials()->getPassword()->match($request->getPassword());
                if ($isPasswordCorrect) {
                    $response->setUser($user);
                } else {
                    $response->addError(
                        new ResponseError(
                            new ErrorMessage(UserError::WRONG_PASSWORD->value),
                            ['wrong_password' => $request->getPassword()->getValue()]
                        )
                    );
                }
            } else {
                $response->addError(
                    new ResponseError(
                        new ErrorMessage(UserError::NOT_FOUND->value),
                        ['email' => $request->getEmail()->getValue()]
                    )
                );
            }
        } catch (RepositoryException $e) {
            $response->addError(
                new ResponseError(
                    new ErrorMessage(UserError::REGISTRATION_FAILED->value),
                    ['user' => $user->jsonSerialize()],
                    $e
                )
            );
        }
        $presenter->present($response);
    }
}