<?php

declare(strict_types=1);

namespace App\Tests\Functional\Identity\Application\Command\CreateUser;

use App\Identity\Application\Command\CreateUser\CreateUserCommand;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\TestCase;
use App\Tests\Tools\FakerTools;

class CreateUserCommandHandlerTest extends TestCase
{
    use FakerTools;

    private CommandBusInterface $commandBus;
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commandBus = $this->getService(CommandBusInterface::class);
        $this->repository = $this->getService(UserRepositoryInterface::class);
    }

    public function test_user_created_successfully(): void
    {
        // arrange
        $command = new CreateUserCommand(
            email: $this->getFaker()->email(),
            name: $this->getFaker()->name(),
            password: $this->getFaker()->password()
        );

        // act
        $userId = $this->commandBus->execute($command);

        // assert
        $user = $this->repository->findById($userId);
        self::assertNotEmpty($user);
    }
}
