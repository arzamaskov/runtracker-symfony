<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Database\Doctrine\Type;

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
        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed' => true,
        ]);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Uuid
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            return Uuid::fromBinary($value);
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

        if ($value instanceof Uuid) {
            return $value->toBinary();
        }

        if (is_string($value)) {
            try {
                return Uuid::fromString($value)->toBinary();
            } catch (\Throwable $e) {
                throw InvalidType::new(
                    $value,
                    self::NAME,
                    ['null', 'string', Uuid::class]
                );
            }
        }

        throw InvalidType::new(
            $value,
            self::NAME,
            ['null', 'string', Uuid::class]
        );
    }
}
