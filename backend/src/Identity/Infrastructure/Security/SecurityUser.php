<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Security;

use App\Identity\Domain\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private User $user)
    {
    }

    public function getRoles(): array
    {
        return $this->user->roles();
    }

    public function eraseCredentials(): void
    {
        // Доменная модель не хранит plaintext пароль
    }

    public function getUserIdentifier(): string
    {
        return $this->user->email();
    }

    public function getPassword(): ?string
    {
        return $this->user->password();
    }

    public function getDomainUser(): User
    {
        return $this->user;
    }
}
