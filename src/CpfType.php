<?php

declare(strict_types=1);

namespace CancioLabs\Doctrine\Type\Cpf;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Stringable;

/**
 * Stores CPF numbers in a CHAR(11) database column.
 */
final class CpfType extends Type
{
    public const string NAME = 'cpf';

    private const int LENGTH = 11;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => self::LENGTH,
            'fixed' => true,
        ]);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value) && !$value instanceof Stringable) {
            throw new ConversionException('CpfType expects a string, a Stringable value, or null.');
        }

        $value = str_replace(['.', '-'], '', (string) $value);

        $this->assertValidCpf($value);

        return $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value) && !$value instanceof Stringable) {
            throw new ConversionException('CpfType expects a string, a Stringable value, or null.');
        }

        $value = (string) $value;

        $this->assertValidCpf($value);

        return sprintf(
            '%s.%s.%s-%s',
            substr($value, 0, 3),
            substr($value, 3, 3),
            substr($value, 6, 3),
            substr($value, 9, 2),
        );
    }

    private function assertValidCpf(string $value): void
    {
        if (preg_match(sprintf('/\\A[0-9]{%d}\\z/', self::LENGTH), $value) !== 1) {
            throw new ConversionException(sprintf('CpfType expects exactly %d digits.', self::LENGTH));
        }
    }
}
