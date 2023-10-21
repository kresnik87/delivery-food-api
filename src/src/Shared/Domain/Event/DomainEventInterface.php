<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Event;

interface DomainEventInterface
{
  public function getAggregateId(): string;

  public function getOccurredOn(): string;

  public function getPerformerId(): ?string;

  public static function getEventName(): string;

  public  function getEventId(): string;

  public static function fromPrimitives(
    string $aggregateId,
    array  $body,
    string $performerId,
    string $occurredOn
  ): static;

  public function toPrimitives(): array;
}
