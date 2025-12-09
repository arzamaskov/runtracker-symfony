<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\EventSubscriber;

use App\Shared\Domain\Exception\DomainExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private string $environment,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->unwrapException($event->getThrowable());

        if ($exception instanceof DomainExceptionInterface) {
            $response = new JsonResponse([
                'success' => false,
                'error' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getErrorCode(),
                ],
            ], $exception->getHttpStatusCode());

            $event->setResponse($response);

            return;
        }

        if ($exception instanceof HttpExceptionInterface) {
            $event->setResponse(new JsonResponse([
                'success' => false,
                'error' => [
                    'message' => $exception->getMessage(),
                ],
            ], $exception->getStatusCode()));

            return;
        }
        $this->logger->error('Unhandled exception', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        $message = 'dev' === $this->environment
            ? $exception->getMessage()
            : 'Internal server error';

        $event->setResponse(new JsonResponse([
            'success' => false,
            'error' => ['message' => $message],
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }

    private function unwrapException(\Throwable $exception): \Throwable
    {
        // HandlerFailedException содержит массив вложенных исключений
        if ($exception instanceof HandlerFailedException) {
            $nestedExceptions = $exception->getWrappedExceptions();

            // Возвращаем первое вложенное исключение
            if (count($nestedExceptions) > 0) {
                return $this->unwrapException(reset($nestedExceptions));
            }
        }

        return $exception;
    }
}
