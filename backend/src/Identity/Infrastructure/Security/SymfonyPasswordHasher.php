<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Security;

use App\Identity\Application\Security\PasswordHasherInterface;
use App\Identity\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

final readonly class SymfonyPasswordHasher implements PasswordHasherInterface
{
    public function __construct(private PasswordHasherFactory $passwordHasherFactory)
    {
    }

    public function hash(string $password): string
    {
        $hasher = $this->passwordHasherFactory->getPasswordHasher(User::class);

        return $hasher->hash($password);
    }
}
