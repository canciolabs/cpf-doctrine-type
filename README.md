# CPF Value Object

This tiny package contains a custom mapping type for CPF value object.

## Requirements

- PHP >= 7.4
- Doctrine DBAL >= 3.0

## Installation

    composer require cancio-labs/cpf-doctrine-type

## How to use it

First, copy the class name of the Cpf mapping type:

    'CancioLabs\Doctrine\Type\Cpf\CpfType'

Then, register it in your application by following one of these guides:

- Symfony Framework: https://symfony.com/doc/current/doctrine/dbal.html
- Doctrine: https://www.doctrine-project.org/projects/doctrine-orm/en/3.2/cookbook/custom-mapping-types.html

Finally, use the 'cpf' mapping type inside your entity:

    use CancioLabs\ValueObject\Cpf\Cpf;

    #[ORM\Column(type: 'cpf')]
    private ?Cpf $cpf = null;