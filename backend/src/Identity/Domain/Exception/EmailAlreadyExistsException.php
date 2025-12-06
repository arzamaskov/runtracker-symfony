<?php

declare(strict_types=1);

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

final class EmailAlreadyExistsException extends IdentityDomainException implements DomainExceptionInterface
{
    public function __construct(string $message = 'Пользователь с таким email уже существует')
    {
        parent::__construct($message);
    }

    public function getErrorCode(): string
    {
        return 'EMAIL_ALREADY_EXISTS';
    }

    public function getHttpStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }
}
