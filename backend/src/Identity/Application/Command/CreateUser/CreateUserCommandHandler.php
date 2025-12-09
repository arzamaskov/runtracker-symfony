<?php

declare(strict_types=1);

namespace App\Identity\Application\Command\CreateUser;

use App\Identity\Application\Security\PasswordHasherInterface;
use App\Identity\Domain\Factory\UserFactory;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher,
        private UserFactory $factory,
    ) {
    }

    public function __invoke(CreateUserCommand $command): UserId
    {
        $hashedPassword = $this->passwordHasher->hash($command->password);

        $user = $this->factory->create($command->email, $command->name, $hashedPassword);
        $this->repository->add($user);

        return $user->id();
    }
}
