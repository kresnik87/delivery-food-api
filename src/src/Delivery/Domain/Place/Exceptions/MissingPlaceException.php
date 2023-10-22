<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\Business\Exceptions;


use KsK\Delivery\Domain\Place\PlaceId;

final class MissingPlaceException extends \RuntimeException
{
    public function __construct(PlaceId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find place with id %s', (string)$id->value()), $code, $previous);
    }
}
