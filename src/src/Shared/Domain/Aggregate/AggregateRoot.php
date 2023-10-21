<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Aggregate;
use KsK\Shared\Domain\Equatable;
use KsK\Shared\Domain\Event\DomainEventInterface;

abstract class AggregateRoot implements Equatable
{
  /**
   * @var DomainEventInterface[]
   */
  private array $domainEvents = [];

  /**
   * @var NotificationEventInterface[]
   */
  private array $notificationEvents = [];

  public function registerEvent(DomainEventInterface $event): void
  {
    $this->domainEvents[] = $event;
  }

  /**
   * @return DomainEventInterface[]
   */
  public function releaseEvents(): array
  {
    $events = $this->domainEvents;
    $this->domainEvents = [];

    return $events;
  }

  public function registerNotificationEvent(NotificationEventInterface $event): void
  {
    $this->notificationEvents[] = $event;
  }

  /**
   * @return NotificationEventInterface[]
   */
  public function releaseNotificationEvents(): array
  {
    $events = $this->notificationEvents;
    $this->notificationEvents = [];

    return $events;
  }


}

