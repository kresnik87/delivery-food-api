<?php

declare(strict_types=1);

namespace KsK\Shared\Domain\Criteria;


final class Filter
{
    const FIELD_NAME = 'field';
    const OPERATOR_NAME = 'operator';
    const VALUE_NAME = 'value';

    public function __construct(
        private readonly FilterField    $field,
        private readonly FilterOperator $operator,
        private readonly FilterValue    $value
    )
    {
    }

    public static function fromValues(array $values): self
    {
        return new self(
            new FilterField($values[self::FIELD_NAME]),
            new FilterOperator($values[self::OPERATOR_NAME]),
            new FilterValue($values[self::VALUE_NAME])
        );
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s.%s', $this->field->value(), $this->operator->value(), $this->value->value());
    }
}
