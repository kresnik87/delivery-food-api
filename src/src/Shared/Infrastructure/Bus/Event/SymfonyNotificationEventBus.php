<?php

namespace KsK\Shared\Infrastructure\Bus\Event;

use KsK\Shared\Application\Bus\Event\NotificationEventBusInterface;
use KsK\Shared\Domain\Event\NotificationEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final  class SymfonyNotificationEventBus implements NotificationEventBusInterface
{
  public function __construct(private MessageBusInterface $notificationEventBus)
  {
  }

  public function dispatch(NotificationEventInterface ...$events): void
  {

    foreach ($events as $event) {
      $this->notificationEventBus->dispatch($event);
    }
  }
}
