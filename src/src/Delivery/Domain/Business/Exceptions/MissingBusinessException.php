<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\Business\Exceptions;


use KsK\Delivery\Domain\Business\BusinessId;

final class MissingBusinessException extends \RuntimeException
{
    public function __construct(BusinessId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find business with id %s', (string)$id->value()), $code, $previous);
    }
}
