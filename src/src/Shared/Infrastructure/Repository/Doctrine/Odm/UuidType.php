<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Persistence\Doctrine\Odm;

use KsK\Shared\Domain\Utils\Utils;
use KsK\Shared\Domain\ValueObject\Uuid;
use KsK\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use function Lambdish\Phunctional\last;

abstract class UuidType extends Type implements DoctrineCustomType
{
    use ClosureToPHP;
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', (string)last(explode('\\', static::class))));
    }

    public function getName(): string
    {

        return self::customTypeName();
    }

    public function convertToPHPValue($value)
    {
        $className = $this->typeClassName();
        return new $className((string)$value);

    }

    public function convertToDatabaseValue($value)
    {
        /** @var Uuid $value */

        return $value instanceof Uuid ? $value->__toString() : $value;

    }
}
