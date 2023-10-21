<?php

namespace KsK\Shared\Application\DomainEventSubscriber;

use KsK\Shared\Application\Bus\Event\DomainEventSubscriberInterface;
use KsK\Shared\Domain\Event\DomainEvent;

final class CreateStoreEventFromDomainEventCreated implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly StoreEventCreator $storeEventCreator
    )
    {
    }


    public function __invoke(DomainEvent $event): void
    {
        $this->storeEventCreator->store($event);
    }
}
