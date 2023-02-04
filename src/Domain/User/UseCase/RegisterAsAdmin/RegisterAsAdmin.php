<?php

declare(strict_types=1);

namespace Shashin\User\UseCase\RegisterAsAdmin;

use Shashin\User\Entity\User;
use Shashin\User\Entity\UserRepositoryInterface;
use Shashin\User\Enum\UserError;
use Shashin\Shared\Authorization\AuthorizationContextInterface;
use Shashin\Shared\Error\ResponseError;
use Shashin\Shared\Exception\RepositoryException;
use Shashin\Shared\UseCase\AdminUseCase;

class RegisterAsAdmin extends AdminUseCase
{
    /**
     * @param UserRepositoryInterface       $userRepository
     * @param AuthorizationContextInterface $authorizationContext
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        AuthorizationContextInterface $authorizationContext
    ) {
        parent::__construct($authorizationContext);
    }

    /**
     * @param User                     $user
     * @param RegisterAsAdminPresenter $presenter
     * @return void
     */
    public function execute(User $user, RegisterAsAdminPresenter $presenter): void
    {
        $response = new RegisterAsAdminResponse();
        try {
            $isAdmin = $this->checkRequester($response);
            $isUserCorrect = $this->checkUser($user, $response);
            if ($isAdmin && $isUserCorrect) {
                $this->userRepository->create($user);
            }
        } catch (RepositoryException $e) {
            $response->addError(
                new ResponseError(
                    UserError::REGISTRATION_FAILED->value,
                    ['user' => $user->jsonSerialize()],
                    $e
                )
            );
        }
        $presenter->present($response);
    }

    /**
     * @param User                    $user
     * @param RegisterAsAdminResponse $response
     * @return bool
     * @throws RepositoryException
     */
    private function checkUser(User $user, RegisterAsAdminResponse $response): bool
    {
        if ($this->userRepository->exists($user->getCredentials())) {
            $response->addError(
                new ResponseError(
                    UserError::EMAIL_ALREADY_EXISTS->value,
                    ['user' => $user->jsonSerialize()]
                )
            );
            return false;
        }
        return true;
    }
}