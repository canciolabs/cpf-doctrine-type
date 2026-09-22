<?php

namespace CancioLabs\Doctrine\Type\Cpf\Tests;

use CancioLabs\Doctrine\Type\Cpf\CpfType;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\TestCase;

final class CpfTypeTest extends TestCase
{
    private CpfType $type;
    private SQLitePlatform $platform;

    protected function setUp(): void
    {
        $this->type = new CpfType();
        $this->platform = new SQLitePlatform();
    }

    public function testItNormalizesDatabaseValuesAndFormatsPhpValues(): void
    {
        self::assertSame(
            '12345678901',
            $this->type->convertToDatabaseValue('12345678901', $this->platform),
        );
        self::assertSame(
            '123.456.789-01',
            $this->type->convertToPHPValue('12345678901', $this->platform),
        );
    }

    public function testItPreservesNull(): void
    {
        self::assertNull($this->type->convertToDatabaseValue(null, $this->platform));
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    public function testItRejectsValuesWithAnInvalidLength(): void
    {
        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue('1234567890', $this->platform);
    }

    public function testItDeclaresAnElevenCharacterFixedColumn(): void
    {
        self::assertSame(
            'CHAR(11)',
            $this->type->getSQLDeclaration([], $this->platform),
        );
    }
}