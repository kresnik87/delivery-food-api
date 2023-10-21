<?php

namespace KsK\Shared\Infrastructure\Symfony\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class AuditMiddleware implements MiddlewareInterface
{

    private $logger;

    public function __construct(LoggerInterface $messengerAuditLogger)
    {
        $this->logger = $messengerAuditLogger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $context = [
            'id' => $envelope->last(ReceivedStamp::class),
            'class' => get_class($envelope->getMessage())
        ];
        if ($envelope->last(ReceivedStamp::class)) {
            $this->logger->info('[{id}] Received {class}', $context);
        } elseif ($envelope->last(SentStamp::class)) {
            $this->logger->info('[{id}] Sent {class}', $context);
        } else {
            $this->logger->info('[{id}] Handling sync {class}', $context);
        }
    }
}
