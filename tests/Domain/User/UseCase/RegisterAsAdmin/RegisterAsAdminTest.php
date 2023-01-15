<?php

declare(strict_types=1);

namespace Shashin\Tests\User\UseCase\RegisterAsAdmin;

use Shashin\Shared\Authorization\AuthorizationContextInterface;
use Shashin\Shared\Exception\RepositoryException;
use Shashin\Tests\User\Entity\UserBuilder;
use Shashin\User\Entity\UserRepositoryInterface;
use Shashin\User\Enum\UserError;
use Shashin\User\UseCase\RegisterAsAdmin\RegisterAsAdmin;
use Shashin\User\UseCase\RegisterAsAdmin\RegisterAsAdminResponse;
use PHPUnit\Framework\TestCase;
use Shashin\User\UseCase\RegisterAsAdmin\RegisterAsAdminPresenter;


class RegisterAsAdminTest extends TestCase implements RegisterAsAdminPresenter
{
    private RegisterAsAdminResponse $response;

    public function present(RegisterAsAdminResponse $response): void
    {
        $this->response = $response;
    }

    public function testCorrectUseCase(): void
    {
        $user = UserBuilder::createUser();
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $authorizationContext = $this->createMock(AuthorizationContextInterface::class);
        $authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $userRepository->method('exists')->willReturn(false);
        $useCase = new RegisterAsAdmin($userRepository, $authorizationContext);
        $useCase->execute($user, $this);
        $this->assertEmpty($this->response->getErrors());
    }

    public function testRequesterNotAdmin(): void
    {
        $user = UserBuilder::createUser();
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $authorizationContext = $this->createMock(AuthorizationContextInterface::class);
        $authorizationContext->method('isRequesterAdmin')->willReturn(false);
        $userRepository->method('exists')->willReturn(false);
        $useCase = new RegisterAsAdmin($userRepository, $authorizationContext);
        $useCase->execute($user, $this);
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals($this->response->getErrors()[0]->getMessage()->getMessage(), UserError::NOT_ADMIN->value);
    }

    public function testUserAlreadyExist(): void
    {
        $user = UserBuilder::createUser();
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $authorizationContext = $this->createMock(AuthorizationContextInterface::class);
        $authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $userRepository->method('exists')->willReturn(true);
        $useCase = new RegisterAsAdmin($userRepository, $authorizationContext);
        $useCase->execute($user, $this);
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::EMAIL_ALREADY_EXISTS->value
        );
    }

    public function testExistsException(): void
    {
        $user = UserBuilder::createUser();
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $authorizationContext = $this->createMock(AuthorizationContextInterface::class);
        $authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $userRepository->method('exists')->willThrowException(new RepositoryException('test'));
        $useCase = new RegisterAsAdmin($userRepository, $authorizationContext);
        $useCase->execute($user, $this);
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::REGISTRATION_FAILED->value
        );
        $this->assertArrayHasKey('user', $this->response->getErrors()[0]->getParameters());
    }

    public function testCreateException(): void
    {
        $user = UserBuilder::createUser();
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $authorizationContext = $this->createMock(AuthorizationContextInterface::class);
        $authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $userRepository->method('create')->willThrowException(new RepositoryException('test'));
        $useCase = new RegisterAsAdmin($userRepository, $authorizationContext);
        $useCase->execute($user, $this);
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::REGISTRATION_FAILED->value
        );
        $this->assertArrayHasKey('user', $this->response->getErrors()[0]->getParameters());
    }
}