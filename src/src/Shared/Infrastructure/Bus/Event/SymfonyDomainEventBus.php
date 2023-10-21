<?php

namespace KSK\Shared\Infrastructure\Bus\Event;

use KsK\Shared\Application\Bus\Event\DomainEventBusInterface;
use KsK\Shared\Domain\Event\DomainEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final  class SymfonyDomainEventBus implements DomainEventBusInterface
{
  public function __construct(private MessageBusInterface $domainEventBus)
  {
  }

  public function dispatch(DomainEventInterface ...$events): void
  {

    foreach ($events as $event) {
      $this->domainEventBus->dispatch($event);
    }
  }
}
