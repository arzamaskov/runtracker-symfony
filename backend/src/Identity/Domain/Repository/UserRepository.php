<?php

declare(strict_types=1);

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Entity\User;
use App\Identity\Domain\ValueObject\UserId;

interface UserRepository
{
    public function add(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(string $email): ?User;
}
