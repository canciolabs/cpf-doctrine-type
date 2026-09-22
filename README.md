# CPF Doctrine Type

[![PHP 8.5+](https://img.shields.io/badge/PHP-8.5%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![License: GPL v3](https://img.shields.io/badge/License-GPL--3.0--or--later-blue.svg)](LICENSE)

A [Doctrine DBAL](https://www.doctrine-project.org/projects/doctrine-dbal.html)
custom mapping type for storing Brazilian CPF values as fixed-length strings.

The type stores values in a `CHAR(11)` column and exposes them as PHP strings.
It does not depend on, create, or return a CPF value object.

## Requirements

- PHP 8.5 or later
- Doctrine DBAL 4.4 or later

## Installation

Install the package with Composer:

```bash
composer require cancio-labs/cpf-doctrine-type
```

## Registering the type

Register the type during application bootstrap, before Doctrine creates metadata
or connections that use it:

```php
use CancioLabs\Doctrine\Type\Cpf\CpfType;
use Doctrine\DBAL\Types\Type;

Type::addType(CpfType::NAME, CpfType::class);
```

For Symfony applications, configure the type in `config/packages/doctrine.yaml`:

```yaml
doctrine:
    dbal:
        types:
            cpf: CancioLabs\Doctrine\Type\Cpf\CpfType
```

## Usage

Map CPF properties as nullable strings:

```php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Person
{
    #[ORM\Column(type: 'cpf', nullable: true)]
    private ?string $cpf = null;
}
```

The database representation is a fixed-length `CHAR(11)` string. When writing
a value, the type accepts `null`, a string, or a `Stringable` object, but the
resulting string must contain exactly 11 characters. Values with any other
length cause a Doctrine conversion exception.

This package enforces storage length only. It does not verify that a value
contains digits or that it has a valid CPF checksum. Validate those business
rules in your application before persistence.

## License

This project is licensed under the [GNU General Public License v3.0 or later](LICENSE).

## Contributing

Please use [GitHub Issues](https://github.com/canciolabs/cpf-doctrine-type/issues)
to report bugs or propose enhancements, and submit changes through pull requests.
