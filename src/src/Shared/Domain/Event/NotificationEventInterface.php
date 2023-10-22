<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Event;

interface NotificationEventInterface
{
  public function getEventId(): string;

  public function getBody(): array;

  public function getPerformerId(): ?string;

  public function getOccurredOn(): string;

  public static function getEventName(): string;

  public static function getEventClass(): string;

  public static function fromPrimitives(
    string $aggregateId,
    array  $body,
    string $performerId,
    string $occurredOn
  ): static;

}
