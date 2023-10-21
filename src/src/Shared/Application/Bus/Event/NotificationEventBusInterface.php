<?php

namespace KsK\Shared\Application\Bus\Event;

use KsK\Shared\Domain\Event\NotificationEventInterface;

interface NotificationEventBusInterface
{
  public function dispatch(NotificationEventInterface ...$events): void;
}
