<?php

declare(strict_types=1);

namespace KsK\Shared\Infrastructure\Service;

interface EventMapperInterface
{
    /**
     * @return array<array-key, class-string>
     */
    public function getEventClasses(string $eventName): array;

    /**
     * @return array<array-key, class-string>
     */
    public function getAllEventClasses():array;
}
