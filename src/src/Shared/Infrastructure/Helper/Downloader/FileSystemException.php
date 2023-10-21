<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Helper\Downloader;


final class FileSystemException extends \RuntimeException
{
    public function __construct(string $msg, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Some error with download msg: %s ', $msg), $code, $previous);
    }
}
