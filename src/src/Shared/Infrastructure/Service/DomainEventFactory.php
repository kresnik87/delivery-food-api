<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Service;


use KsK\Shared\Domain\Event\DomainEventInterface;
use KsK\Shared\Domain\Service\DomainEventFactoryInterface;

final  class DomainEventFactory implements DomainEventFactoryInterface
{
    public function __construct(
        private DomainEventMapperInterface $mapper
    ) {
    }

    /**
     * @return DomainEventInterface[]
     */
    public function create(
        string $eventName,
        string $aggregateId,
        array $body,
        string $performerId,
        string $occurredOn
    ): array {
        /** @var DomainEventInterface[] $classes */
        $classes = $this->mapper->getEventClasses($eventName);
        $result = [];
        foreach ($classes as $class) {
            $result[] = $class::fromPrimitives(
                $aggregateId,
                $body,
                $performerId,
                $occurredOn
            );
        }

        return $result;
    }
}
