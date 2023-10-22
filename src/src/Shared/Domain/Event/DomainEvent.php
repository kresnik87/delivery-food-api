<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Event;



abstract class DomainEvent implements DomainEventInterface
{
  private readonly string $occurredOn;
  private readonly Uuid $eventId;

  public function __construct(
    private readonly string  $aggregateId,
    private readonly ?string $performerId,
    string                   $occurredOn = null
  )
  {
    $this->eventId = Uuid::random();
    $this->occurredOn = $occurredOn ?: (new DateTime())->getValue();
  }

  public function getAggregateId(): string
  {
    return $this->aggregateId;
  }

  public function getOccurredOn(): string
  {
    return $this->occurredOn;
  }

  public function getPerformerId(): ?string
  {
    return $this->performerId;
  }

  public  function getEventId(): string
  {
    return $this->eventId->value();
  }


}

