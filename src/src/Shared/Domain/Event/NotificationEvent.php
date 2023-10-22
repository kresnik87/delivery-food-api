<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Event;
abstract class NotificationEvent implements NotificationEventInterface
{
  private readonly string $occurredOn;

  private readonly string $eventId;

  public function __construct(
    private readonly string $aggregateId,
    private readonly ?string $performerId,
    string $occurredOn = null
  ) {
    $this->eventId = Uuid::random()->value();
    $this->occurredOn = $occurredOn ?: (new DateTime())->getValue();
  }



  public function getAggregateId(): string
  {
    return $this->aggregateId;
  }

  /**
   * @return string
   */
  public function getEventId(): string
  {
    return $this->eventId;
  }



  public function getOccurredOn(): string
  {
    return $this->occurredOn;
  }

  /**
   * @return string|null
   */
  public function getPerformerId(): ?string
  {
    return $this->performerId;
  }


}
