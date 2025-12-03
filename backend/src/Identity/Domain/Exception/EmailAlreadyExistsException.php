<?php

declare(strict_types=1);

namespace App\Identity\Domain\Exception;

final class EmailAlreadyExistsException extends IdentityDomainException
{
    public function __construct(string $message = 'Пользователь с таким email уже существует')
    {
        parent::__construct($message);
    }
}
