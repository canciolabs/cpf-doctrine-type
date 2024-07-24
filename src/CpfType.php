<?php

namespace CancioLabs\Doctrine\Type\Cpf;

use CancioLabs\ValueObject\Cpf\Cpf;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class CpfType extends Type
{

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 11;
        $column['fixed'] = true;

        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Cpf
    {
        if ($value === null) {
            return null;
        }

        return new Cpf($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->getRaw();
    }

    public function getName(): string
    {
        return 'cpf';
    }

}