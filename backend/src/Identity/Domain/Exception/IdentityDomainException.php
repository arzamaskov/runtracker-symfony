<?php

declare(strict_types=1);

namespace App\Identity\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

/**
 * Базовое исключение для домена Identity.
 *
 * Все исключения модуля Identity должны наследоваться от этого класса.
 */
class IdentityDomainException extends DomainException
{
}
