<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\Rate\Exceptions;


use KsK\Delivery\Domain\Rate\RateId;

final class MissingRateException extends \RuntimeException
{
    public function __construct(RateId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find rate with id %s', (string)$id->value()), $code, $previous);
    }
}
