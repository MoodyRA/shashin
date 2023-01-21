<?php

declare(strict_types=1);

namespace Shashin\Tests\User\UseCase\RegisterAsAdmin;

use Moody\ValueObject\ValueObjectIncorrectValueException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\IncompatibleReturnValueException;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
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
    /** @var RegisterAsAdminResponse  */
    private RegisterAsAdminResponse $response;

    /** @var (UserRepositoryInterface&MockObject) */
    private UserRepositoryInterface&MockObject $userRepository;

    private AuthorizationContextInterface&MockObject $authorizationContext;

    /**
     * @param RegisterAsAdminResponse $response
     * @return void
     */
    public function present(RegisterAsAdminResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->authorizationContext = $this->createMock(AuthorizationContextInterface::class);
    }

    /**
     * @return void
     * @throws ValueObjectIncorrectValueException
     * @throws RuntimeException
     */
    public function executeUseCase(): void
    {
        $useCase = new RegisterAsAdmin($this->userRepository, $this->authorizationContext);
        $useCase->execute(UserBuilder::createUser(), $this);
    }

    /**
     * @return void
     * @throws RuntimeException
     * @throws ValueObjectIncorrectValueException
     * @throws ExpectationFailedException
     * @throws IncompatibleReturnValueException
     * @throws InvalidArgumentException
     */
    public function testCorrectUseCase(): void
    {
        $this->authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $this->userRepository->method('exists')->willReturn(false);
        $this->executeUseCase();
        $this->assertEmpty($this->response->getErrors());
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws IncompatibleReturnValueException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ValueObjectIncorrectValueException
     */
    public function testRequesterNotAdmin(): void
    {
        $this->authorizationContext->method('isRequesterAdmin')->willReturn(false);
        $this->userRepository->method('exists')->willReturn(false);
        $this->executeUseCase();
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals($this->response->getErrors()[0]->getMessage()->getMessage(), UserError::NOT_ADMIN->value);
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws IncompatibleReturnValueException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ValueObjectIncorrectValueException
     */
    public function testUserAlreadyExist(): void
    {
        $this->authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $this->userRepository->method('exists')->willReturn(true);
        $this->executeUseCase();
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::EMAIL_ALREADY_EXISTS->value
        );
    }

    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws IncompatibleReturnValueException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ValueObjectIncorrectValueException
     * @throws Exception
     */
    public function testExistsException(): void
    {
        $this->authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $this->userRepository->method('exists')->willThrowException(new RepositoryException('test'));
        $this->executeUseCase();
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::REGISTRATION_FAILED->value
        );
        $this->assertArrayHasKey('user', $this->response->getErrors()[0]->getParameters());
    }

    /**
     * @return void
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws IncompatibleReturnValueException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ValueObjectIncorrectValueException
     */
    public function testCreateException(): void
    {
        $this->authorizationContext->method('isRequesterAdmin')->willReturn(true);
        $this->userRepository->method('create')->willThrowException(new RepositoryException('test'));
        $this->executeUseCase();
        $this->assertNotEmpty($this->response->getErrors());
        $this->assertEquals(
            $this->response->getErrors()[0]->getMessage()->getMessage(),
            UserError::REGISTRATION_FAILED->value
        );
        $this->assertArrayHasKey('user', $this->response->getErrors()[0]->getParameters());
    }
}