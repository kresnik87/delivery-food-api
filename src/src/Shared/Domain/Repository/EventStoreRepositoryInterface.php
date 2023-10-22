<?php

namespace KsK\Shared\Domain\Repository;

use KsK\Shared\Domain\Event\DomainEvent;
use KsK\Shared\Domain\Event\StoredEvent;

interface EventStoreRepositoryInterface
{
  public function append(DomainEvent $aDomainEvent): void;

  public function allStoredEventsSince($storeEventId): array;

  public function findByEventId(string $eventId):?StoredEvent;

  public function save(StoredEvent $event):void;
}
