<?php

namespace KsK\Shared\Infrastructure\Persistence;


use Doctrine\ORM\EntityManagerInterface;
use KsK\Shared\Domain\Event\DomainEvent;
use KsK\Shared\Domain\Event\StoredEvent;
use KsK\Shared\Domain\Repository\EventStoreRepositoryInterface;
use KsK\Shared\Infrastructure\Doctrine\DoctrineRepository;

class DoctrineEventStoreRepository extends DoctrineRepository implements EventStoreRepositoryInterface
{

    private const ENTITY_CLASS = StoredEvent::class;
    private const ALIAS = 'storeEvent';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function append(DomainEvent $aDomainEvent, bool $flush = false): void
    {
        $storedEvent = new StoredEvent(
            $aDomainEvent->toPrimitives(),
            $aDomainEvent->getEventId(),
            $aDomainEvent->getOccurredOn(),
            get_class($aDomainEvent)
        );
        $this->em->persist($storedEvent);

        if ($flush) {
            $this->em->flush($storedEvent);
        }
    }

    public function allStoredEventsSince($storeEventId): array
    {
        $query = $this->query();
        if ($storeEventId) {
            $query->where('storeEvent.id > :eventId');
            $query->setParameters(array('id' => $storeEventId));
        }
        $query->orderBy('storeEvent.eventId');

        return $query->getQuery()->getResult();
    }

    public function findByEventId(string $eventId): ?StoredEvent
    {
        $query = $this->query();
        $query->where('storeEvent.eventId = :eventId');
        $query->setParameter("eventId",$eventId);
        return $query->getQuery()->getOneOrNullResult();
    }

    public function save(StoredEvent $event): void
    {
        $this->em->persist($event);
        $this->em->flush($event);
    }
}
