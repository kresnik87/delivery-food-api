<?php

namespace KsK\Shared\Application\DomainEventSubscriber;

use KsK\Shared\Domain\Event\DomainEvent;
use KsK\Shared\Domain\Repository\EventStoreRepositoryInterface;

class StoreEventCreator
{
    public function __construct(
        private readonly EventStoreRepositoryInterface $eventStoreRepository
    )
    {
    }

    public function store(DomainEvent $event): void
    {
        $found = $this->eventStoreRepository->findByEventId($event->getEventId());
        if (null == $found) {
            $this->eventStoreRepository->append($event, true);
        }
    }
}
