<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Helper\Storage;


final class StorageException extends \RuntimeException
{
    public function __construct(string $msg, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Some error with storage helper msg: %s ', $msg), $code, $previous);
    }
}
