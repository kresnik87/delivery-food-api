<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Service;


use KsK\Shared\Domain\Event\NotificationEventInterface;

final class NotificationEventMapper implements NotificationEventMapperInterface
{
    private array $map = [];

    public function __construct(private readonly array $events)
    {
        $this->indexMap();
    }

    /**
     * @return array<array-key, class-string>
     */
    public function getEventClasses(string $eventName): array
    {
        return $this->map[$eventName] ?? [];
    }

    private function indexMap(): void
    {
        if (empty($this->map)) {
            foreach ($this->events as $eventClass) {
                if (!is_subclass_of($eventClass, NotificationEventInterface::class)) {
                    throw new \LogicException(sprintf('"%s" must be instance of NotificationEvent', $eventClass));
                }
                $eventName = $eventClass::getEventName();
                $className = (new \ReflectionClass($eventClass))->getShortName();
                $this->map[$className] = $eventName;
            }
        }
    }

    public function getAllEventClasses(): array
    {
        return $this->map;
    }
}
