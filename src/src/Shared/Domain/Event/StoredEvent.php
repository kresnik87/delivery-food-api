<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Event;

class StoredEvent
{
  private int $storedId;

  public function __construct(

    private array  $eventBody,
    private string $eventId,
    private string $occurredOn,
    private string $typeName,
    private bool   $consumed = false
  )
  {
  }

  /**
   * @return int
   */
  public function getStoredId(): int
  {
    return $this->storedId;
  }

  /**
   * @return array
   */
  public function getEventBody(): array
  {
    return $this->eventBody;
  }

  /**
   * @return String
   */
  public function getOccurredOn(): string
  {
    return $this->occurredOn;
  }

  /**
   * @return string
   */
  public function getTypeName(): string
  {
    return $this->typeName;
  }

  /**
   * @return string
   */
  public function getEventId(): string
  {
    return $this->eventId;
  }

  public function consumeEvent():void
  {
    $this->consumed = true;
  }

  /**
   * @return bool
   */
  public function isConsumed(): bool
  {
    return $this->consumed;
  }

}
