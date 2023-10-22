<?php

namespace KsK\Delivery\Domain\User\Events;


use KsK\Shared\Domain\Event\DomainEvent;

final class UserWasCreated extends DomainEvent
{
  const EVENT_NAME="ksk.delivery.domain.user.created";
    public function __construct(
        string                  $id,
        private readonly string $email,
        string                  $performerId = null,
        string                  $occurredOn = null
    )
    {
        parent::__construct($id, $performerId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $performerId, string $occurredOn): static
    {
        return new self($aggregateId, $body['email'], $performerId, $occurredOn);// TODO: Implement fromPrimitives() method.
    }


    public function toPrimitives(): array
    {
        return [
            'email' => $this->email,
        ];
    }



    public function getEmail(): string
    {
        return $this->email;
    }

    public static function getEventName(): string
    {
        return self::EVENT_NAME;
    }
}
