<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Database\Doctrine\Type;

use App\Identity\Domain\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\Uuid;

final class UserIdType extends Type
{
    public const string NAME = 'user_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'UUID';
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UserId
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof UserId) {
            return $value;
        }

        try {
            // PostgreSQL может возвращать UUID как resource
            if (is_resource($value)) {
                $value = stream_get_contents($value);
                if (false === $value) {
                    throw new \RuntimeException('Failed to read UUID from stream');
                }
            }

            if (!is_string($value)) {
                throw new \InvalidArgumentException(
                    sprintf('Expected string value, got %s', get_debug_type($value))
                );
            }

            $uuid = Uuid::fromString($value);

            return UserId::fromUuid($uuid);
        } catch (\Throwable $e) {
            throw ValueNotConvertible::new(
                is_scalar($value) ? (string) $value : get_debug_type($value),
                self::NAME,
                $e->getMessage()
            );
        }
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof UserId) {
            return $value->value()->toRfc4122();
        }

        if ($value instanceof Uuid) {
            return $value->toRfc4122();
        }

        if (is_string($value)) {
            try {
                return Uuid::fromString($value)->toRfc4122();
            } catch (\Throwable $e) {
                throw InvalidType::new(
                    $value,
                    self::NAME,
                    ['null', 'string', UserId::class, Uuid::class]
                );
            }
        }

        throw InvalidType::new(
            $value,
            self::NAME,
            ['null', 'string', UserId::class, Uuid::class]
        );
    }
}
