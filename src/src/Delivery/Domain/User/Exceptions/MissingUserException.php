<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\User\Exceptions;


use KsK\Delivery\Domain\User\UserId;

final class MissingUserException extends \RuntimeException
{
    public function __construct(UserId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find user with id %s', (string)$id->value()), $code, $previous);
    }
}
