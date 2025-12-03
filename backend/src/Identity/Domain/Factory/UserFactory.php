<?php

declare(strict_types=1);

namespace App\Identity\Domain\Factory;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\Repository\UserRepositoryInterface;
use App\Identity\Domain\ValueObject\UserId;

readonly class UserFactory
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function create(string $email, string $hashedPassword): User
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new \InvalidArgumentException('User with this email already exists');
        }

        $id = UserId::generate();

        return new User($id, $email, $hashedPassword);
    }
}
