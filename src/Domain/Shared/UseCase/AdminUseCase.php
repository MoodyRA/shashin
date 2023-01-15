<?php

namespace Shashin\Shared\UseCase;

use Shashin\User\Enum\UserError;
use Shashin\Shared\Authorization\AuthorizationContextInterface;
use Shashin\Shared\Error\ErrorMessage;
use Shashin\Shared\Error\ResponseError;
use Shashin\Shared\Exception\UnexpectedValueException;

class AdminUseCase
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     */
    public function __construct(
        protected AuthorizationContextInterface $authorizationContext
    ) {
    }

    /**
     * @param AbstractErrorResponse $response
     * @return bool
     */
    protected function checkRequester(AbstractErrorResponse $response): bool
    {
        if (!$this->authorizationContext->isRequesterAdmin()) {
            $response->addError(
                new ResponseError(
                    new ErrorMessage(UserError::NOT_ADMIN->value),
                    ['requester' => $this->authorizationContext->getRequester()->jsonSerialize()]
                )
            );
            return false;
        }
        return true;
    }
}