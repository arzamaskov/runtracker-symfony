<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class RegisterRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'Email обязателен')]
        #[Assert\Email(message: 'Некорректный email', mode: 'strict')]
        public string $email,
        #[Assert\NotBlank(message: 'Имя обязательно')]
        public string $name,
        #[Assert\NotBlank(message: 'Пароль обязателен')]
        #[Assert\Length(min: 8, minMessage: 'Пароль должен быть не менее 8 символов')]
        public string $password,
    ) {
    }
}
