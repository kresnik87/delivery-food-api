<?php
declare(strict_types=1);

namespace KsK\Shared\Application\Bus\Event;

use KsK\Shared\Domain\Event\DomainEventInterface;

interface DomainEventBusInterface
{
  public function dispatch(DomainEventInterface ...$events): void;

}
