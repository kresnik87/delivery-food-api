<?php

namespace KsK\Shared\Domain\Service;

use KsK\Shared\Domain\Event\DomainEventInterface;

interface DomainEventFactoryInterface
{
  /**
   * @return DomainEventInterface[]
   */
  public function create(
    string $eventName,
    string $aggregateId,
    array $body,
    string $performerId,
    string $occurredOn
  ): array;
}
