<?php

declare(strict_types=1);

namespace App\Identity\Application\DTO;

use App\Identity\Domain\Entity\User;

final class UserDTO
{
    public function __construct(public string $uuid, public string $email)
    {
    }

    public static function fromEntity(User $user): self
    {
        return new self($user->id()->toString(), $user->email());
    }
}
