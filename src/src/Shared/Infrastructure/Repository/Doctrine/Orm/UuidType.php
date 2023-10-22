<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Persistence\Doctrine\Orm;

use KsK\Shared\Domain\Utils\Utils;
use KsK\Shared\Domain\ValueObject\Uuid;
use KsK\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use function Lambdish\Phunctional\last;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', (string)last(explode('\\', static::class))));
    }

    public function getName(): string
    {

        return self::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->typeClassName();
        if (!is_null($value)) {
            return new $className($value);
        }

    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Uuid $value */
        if(!is_null($value)){
            return $value->value();
        }

    }
}
