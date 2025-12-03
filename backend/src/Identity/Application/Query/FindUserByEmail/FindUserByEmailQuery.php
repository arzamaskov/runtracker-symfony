<?php

declare(strict_types=1);

namespace App\Identity\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryInterface;

final class FindUserByEmailQuery implements QueryInterface
{
    public function __construct(public string $email)
    {
    }
}
