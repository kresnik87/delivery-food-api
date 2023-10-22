<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\Menu\Exceptions;


use KsK\Delivery\Domain\Menu\MenuId;

final class MissingMenuException extends \RuntimeException
{
    public function __construct(MenuId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find menu with id %s', (string)$id->value()), $code, $previous);
    }
}
