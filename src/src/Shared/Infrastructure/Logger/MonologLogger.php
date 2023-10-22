<?php

declare(strict_types=1);

namespace  KsK\Shared\Infrastructure\Logger;



use KsK\Shared\Domain\Logger;
use Psr\Log\LoggerInterface;

final class MonologLogger implements Logger
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}
