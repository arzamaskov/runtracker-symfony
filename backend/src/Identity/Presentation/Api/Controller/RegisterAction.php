<?php

declare(strict_types=1);

namespace App\Identity\Presentation\Api\Controller;

use App\Identity\Application\Command\CreateUser\CreateUserCommand;
use App\Identity\Domain\ValueObject\UserId;
use App\Identity\Presentation\Api\Request\RegisterRequest;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/auth/register', name: 'register', methods: ['POST'])]
final readonly class RegisterAction
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(#[MapRequestPayload] RegisterRequest $request): JsonResponse
    {
        $command = new CreateUserCommand(
            email: $request->email,
            name: $request->name,
            password: $request->password
        );

        /** @var UserId $userId */
        $userId = $this->commandBus->execute($command);

        return new JsonResponse([
            'success' => true,
            'data' => [
                'id' => $userId->toString(),
            ],
        ], Response::HTTP_CREATED);
    }
}
